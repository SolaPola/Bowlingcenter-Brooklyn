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
        $procedure = "
            CREATE PROCEDURE spGetAccountsInfo()
            BEGIN
                SELECT 
                    CONCAT(
                        person.firstName, 
                        ' ', 
                        IF(person.infix IS NULL OR person.infix = '', '', CONCAT(person.infix, ' ')), 
                        person.lastName
                    ) AS fullName,
                    contact.phoneNumber AS mobileNumber,
                    contact.email AS emailAddress,
                    CASE 
                        WHEN person.isAdult = 1 THEN 'Ja'
                        ELSE 'Nee'
                    END AS isAdult,
                    person.id AS personId
                FROM person
                LEFT JOIN contact ON person.id = contact.personId
                LEFT JOIN typePerson ON person.typePerson_id = typePerson.id
                WHERE person.isActive = 1 AND contact.isActive = 1
                ORDER BY person.lastName, person.firstName;
            END
        ";
        
        DB::unprepared("DROP PROCEDURE IF EXISTS spGetAccountsInfo");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS spGetAccountsInfo");
    }
};
