<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateGetScoreOverviewProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
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
                0 AS AantalKinderen, 
                SUM(s.amount) AS Score
            FROM reservation r
            JOIN customer c ON r.customerId = c.id
            JOIN person p ON c.personId = p.id
            LEFT JOIN timeslot t ON r.timeslotId = t.id
            LEFT JOIN score s ON c.scoreId = s.id
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

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetScoreOverview');
    }
}