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
        DROP PROCEDURE IF EXISTS GetReservationDetails;
        CREATE PROCEDURE GetReservationDetails(IN reservationId INT)
        BEGIN
            -- Get reservation details with related information
            SELECT 
                r.id AS ReservationId,
                r.date AS ReservationDate,
                r.minutes AS Duration,
                r.status AS Status,
                r.numberOfPeople AS NumberOfPeople,
                r.note AS ReservationNote,
                
                c.id AS CustomerId,
                p.firstName AS CustomerFirstName,
                p.infix AS CustomerInfix,
                p.lastName AS CustomerLastName,
                p.nickname AS CustomerNickname,
                p.isAdult AS IsAdult,
                
                co.email AS Email,
                co.phoneNumber AS PhoneNumber,
                co.address AS Address,
                
                s.amount AS ScoreAmount,
                
                ct.number AS CourtNumber,
                
                t.startTime AS StartTime,
                t.endTime AS EndTime,
                t.day AS Day,
                
                o.orderNumber AS OrderNumber,
                o.orderDate AS OrderDate,
                o.packageType AS PackageType,
                o.note AS OrderNote
            FROM reservation r
            JOIN customer c ON r.customerId = c.id
            JOIN person p ON c.personId = p.id
            LEFT JOIN contact co ON p.id = co.personId
            LEFT JOIN score s ON c.scoreId = s.id
            JOIN court ct ON r.courtId = ct.id
            JOIN timeslot t ON r.timeslotId = t.id
            LEFT JOIN `order` o ON r.id = o.reservationId
            WHERE r.id = reservationId;
        END
        ');

        // Stored procedure for the edit view
        DB::unprepared('
        DROP PROCEDURE IF EXISTS GetReservationForEdit;
        CREATE PROCEDURE GetReservationForEdit(IN reservationId INT)
        BEGIN
            -- Main reservation details
            SELECT 
                r.id AS ReservationId,
                r.customerId AS CustomerId,
                r.courtId AS CourtId,
                r.timeslotId AS TimeslotId,
                r.date AS ReservationDate,
                r.minutes AS Duration,
                r.status AS Status,
                r.numberOfPeople AS NumberOfPeople,
                r.note AS Note
            FROM reservation r
            WHERE r.id = reservationId;

            -- Available courts (for dropdown)
            SELECT 
                id,
                number AS CourtNumber
            FROM court
            WHERE isActive = 1;

            -- Available timeslots (for dropdown)
            SELECT 
                id,
                startTime,
                endTime,
                day
            FROM timeslot
            WHERE isActive = 1;

            -- Customer information
            SELECT 
                c.id AS CustomerId,
                p.firstName,
                p.infix,
                p.lastName,
                p.nickname,
                p.isAdult,
                co.email,
                co.phoneNumber,
                co.address,
                s.amount AS ScoreAmount
            FROM customer c
            JOIN person p ON c.personId = p.id
            LEFT JOIN contact co ON p.id = co.personId
            LEFT JOIN score s ON c.scoreId = s.id
            WHERE c.id = (SELECT customerId FROM reservation WHERE id = reservationId);

            -- Order information if exists
            SELECT 
                id AS OrderId,
                orderNumber,
                orderDate,
                packageType,
                note
            FROM `order`
            WHERE reservationId = reservationId;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetScoreOverview');
    }
};
