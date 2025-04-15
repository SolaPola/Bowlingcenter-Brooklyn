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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetScoreOverview');
    }
};
