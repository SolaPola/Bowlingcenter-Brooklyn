<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetReserveringDetailsSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetReserveringDetails');
        DB::unprepared('
            CREATE PROCEDURE GetReserveringDetails()
            BEGIN
                SELECT 
                    CONCAT(p.Voornaam, " ", IFNULL(p.Tussenvoegsel, ""), " ", p.Achternaam) AS Naam,
                    r.Datum,
                    r.AantalVolwassen,
                    r.AantalKinderen,
                    r.BaanId
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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetReserveringDetails');
    }
}
