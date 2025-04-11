<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetReserveringOverzichtSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetReserveringOverzicht');
        DB::unprepared('
            CREATE PROCEDURE GetReserveringOverzicht()
            BEGIN
                SELECT 
                    CONCAT(p.Voornaam, " ", IFNULL(p.Tussenvoegsel, ""), " ", p.Achternaam) AS Naam,
                    r.Datum,
                    r.AantalUren,
                    r.AantalVolwassen,
                    r.AantalKinderen,
                    r.ReserveringStatus
                FROM 
                    persoon p
                INNER JOIN 
                    reservering r
                ON 
                    p.Id = r.PersoonId;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetReserveringOverzicht');
    }
}
