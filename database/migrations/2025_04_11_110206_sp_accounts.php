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
        
        $updateProcedure = "
            CREATE PROCEDURE spUpdateAccountInfo(
                IN p_personId INT,
                IN p_firstName VARCHAR(255),
                IN p_infix VARCHAR(255),
                IN p_lastName VARCHAR(255),
                IN p_mobileNumber VARCHAR(255),
                IN p_emailAddress VARCHAR(255),
                IN p_isAdult TINYINT
            )
            BEGIN
                -- Update person information
                UPDATE person 
                SET 
                    firstName = p_firstName,
                    infix = p_infix,
                    lastName = p_lastName,
                    isAdult = p_isAdult,
                    updatedAt = NOW()
                WHERE id = p_personId;
                
                -- Update contact information
                UPDATE contact 
                SET 
                    phoneNumber = p_mobileNumber,
                    email = p_emailAddress,
                    updatedAt = NOW()
                WHERE personId = p_personId AND isActive = 1;
            END
        ";
        
        $getAccountByIdProcedure = "
            CREATE PROCEDURE spGetAccountById(
                IN p_personId INT
            )
            BEGIN
                SELECT 
                    CONCAT(
                        person.firstName, 
                        ' ', 
                        IF(person.infix IS NULL OR person.infix = '', '', CONCAT(person.infix, ' ')), 
                        person.lastName
                    ) AS fullName,
                    person.firstName,
                    person.infix,
                    person.lastName,
                    contact.phoneNumber AS mobileNumber,
                    contact.email AS emailAddress,
                    CASE 
                        WHEN person.isAdult = 1 THEN 'Ja'
                        ELSE 'Nee'
                    END AS isAdult,
                    person.isAdult AS isAdultValue,
                    person.id AS personId
                FROM person
                LEFT JOIN contact ON person.id = contact.personId
                WHERE person.isActive = 1 AND contact.isActive = 1
                AND person.id = p_personId;
            END
        ";
        
        DB::unprepared("DROP PROCEDURE IF EXISTS spGetAccountsInfo");
        DB::unprepared($procedure);
        
        DB::unprepared("DROP PROCEDURE IF EXISTS spUpdateAccountInfo");
        DB::unprepared($updateProcedure);
        
        DB::unprepared("DROP PROCEDURE IF EXISTS spGetAccountById");
        DB::unprepared($getAccountByIdProcedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS spGetAccountsInfo");
        DB::unprepared("DROP PROCEDURE IF EXISTS spUpdateAccountInfo");
        DB::unprepared("DROP PROCEDURE IF EXISTS spGetAccountById");
    }
};
