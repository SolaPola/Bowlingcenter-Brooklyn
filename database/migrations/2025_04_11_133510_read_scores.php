<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        DROP PROCEDURE IF EXISTS ReadScores;
        CREATE PROCEDURE ReadScores(
        in givRESID int unsigned
        )
        BEGIN
            SELECT 
                p.firstName AS Naam,
                s.amount AS Score
            FROM reservation r
            JOIN customer c ON r.customerId = c.id
            JOIN person p ON c.personId = p.id
            LEFT JOIN score s ON c.scoreId = s.id
            WHERE s.ReservationId = givRESID
          ;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
