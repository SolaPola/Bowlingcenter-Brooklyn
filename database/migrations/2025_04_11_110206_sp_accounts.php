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
            CREATE PROCEDURE spGetAccountsInfo(
                IN p_startDate DATE,
                IN p_endDate DATE
            )
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
                LEFT JOIN customer ON person.id = customer.personId
                WHERE person.isActive = 1 AND contact.isActive = 1
                AND (
                    (p_startDate IS NULL AND p_endDate IS NULL) OR
                    (person.createdAt BETWEEN 
                        IFNULL(p_startDate, '1900-01-01') AND 
                        IFNULL(p_endDate, CURRENT_TIMESTAMP())
                    )
                )
                ORDER BY person.lastName ASC, person.firstName ASC;
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
