<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateEditScoreProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
        
        DROP PROCEDURE IF EXISTS EditScore;
        CREATE PROCEDURE EditScore(IN scoreId INT, IN newScore INT)
        BEGIN
            UPDATE score
            SET amount = newScore
            WHERE id = scoreId;
        END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS EditScore');
    }
}
