<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateInsertPersonScoreMembershipProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertPersonScoreMembership'); // Drop procedure if it exists
        DB::unprepared('
            CREATE PROCEDURE InsertPersonScoreMembership(
                IN firstName VARCHAR(100),
                IN lastName VARCHAR(100),
                IN amount INT,
                IN membershipType VARCHAR(50)
            )
            BEGIN
                DECLARE personId BIGINT;
                DECLARE scoreId BIGINT;

                -- Insert into person table
                INSERT INTO person (firstName, lastName, createdAt, updatedAt)
                VALUES (firstName, lastName, NOW(), NOW());
                SET personId = LAST_INSERT_ID();

                -- Insertinto score table
                INSERT INTO score (amount, createdAt, updatedAt)
                VALUES (amount, NOW(), NOW());
                SET scoreId = LAST_INSERT_ID();

                -- Insert into customer table
                INSERT INTO customer (personId, scoreId, membershipType, createdAt, updatedAt)
                VALUES (personId, scoreId, membershipType, NOW(), NOW());
            END
        ');

        DB::unprepared('DROP PROCEDURE IF EXISTS EditPersonScoreMembership'); // Drop procedure if it exists
        DB::unprepared('
            CREATE PROCEDURE EditPersonScoreMembership(
                IN personId BIGINT,
                IN firstName VARCHAR(100),
                IN lastName VARCHAR(100),
                IN scoreId BIGINT,
                IN amount INT,
                IN membershipType VARCHAR(50)
            )
            BEGIN
                -- Update person table
                UPDATE person
                SET firstName = firstName, lastName = lastName, updatedAt = NOW()
                WHERE id = personId;

                -- Update score table
                UPDATE score
                SET amount = amount, updatedAt = NOW()
                WHERE id = scoreId;

                -- Update customer table
                UPDATE customer
                SET membershipType = membershipType, updatedAt = NOW()
                WHERE personId = personId AND scoreId = scoreId;
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
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertPersonScoreMembership');
        DB::unprepared('DROP PROCEDURE IF EXISTS EditPersonScoreMembership');
    }
}
