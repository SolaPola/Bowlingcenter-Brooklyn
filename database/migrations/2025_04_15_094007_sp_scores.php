<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        DROP PROCEDURE IF EXISTS GetScoreOverview;
        CREATE PROCEDURE GetScoreOverview()
        BEGIN
            SELECT 
                r.id AS ReservationId, 
                p.firstName AS Naam,
                r.date AS Datum,
                r.minutes AS AantalUren,
                t.startTime AS BeginTijd,
                t.endTime AS EindTijd,
                r.numberOfPeople AS AantalVolwassenen,
                0 AS AantalKinderen 
            FROM reservation r
            JOIN customer c ON r.customerId = c.id
            JOIN person p ON c.personId = p.id
            LEFT JOIN timeslot t ON r.timeslotId = t.id
            GROUP BY 
                r.id, -- Add the primary key to the GROUP BY clause
                p.firstName,
                r.date,
                r.minutes,
                t.startTime,
                t.endTime,
                r.numberOfPeople;
        END
        ');

        DB::unprepared('
        DROP PROCEDURE IF EXISTS EditIndex;
        CREATE PROCEDURE EditIndex(
            IN p_scoreId INT,
            IN p_amount INT
        )
        BEGIN
            UPDATE score
            SET 
                amount = p_amount
            WHERE id = p_scoreId;
            SELECT id, amount FROM score WHERE id = p_scoreId;
        END
        ');

        DB::unprepared('
        DROP PROCEDURE IF EXISTS InsertPersonScoreMembership;
        CREATE PROCEDURE InsertPersonScoreMembership(
            IN p_firstName VARCHAR(100),
            IN p_lastName VARCHAR(100),
            IN p_amount INT,
            IN p_membershipType VARCHAR(50)
        )
        BEGIN
            DECLARE personId INT;
            DECLARE scoreId INT;
            
            -- Insert into person table with default isAdult value (1 for true)
            -- and current timestamp for createdAt and updatedAt
            INSERT INTO person (firstName, lastName, isAdult, createdAt, updatedAt) 
            VALUES (p_firstName, p_lastName, 1, NOW(), NOW());
            
            SET personId = LAST_INSERT_ID();
            
            -- Insert into score table with current timestamp for createdAt and updatedAt
            INSERT INTO score (amount, createdAt, updatedAt) 
            VALUES (p_amount, NOW(), NOW());
            
            SET scoreId = LAST_INSERT_ID();
            
            -- Insert into customer table with current timestamp for createdAt and updatedAt
            INSERT INTO customer (personId, scoreId, membershipType, createdAt, updatedAt) 
            VALUES (personId, scoreId, p_membershipType, NOW(), NOW());
            
            -- Return the inserted data
            SELECT p.firstName, p.lastName, s.amount, c.membershipType
            FROM person p
            JOIN customer c ON p.id = c.personId
            JOIN score s ON c.scoreId = s.id
            WHERE p.id = personId;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetScoreOverview');
        DB::unprepared('DROP PROCEDURE IF EXISTS EditIndex');
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertPersonScoreMembership');
    }
};