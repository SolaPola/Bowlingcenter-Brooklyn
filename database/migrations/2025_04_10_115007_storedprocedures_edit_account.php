<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         // Create the stored procedure
//         DB::unprepared('
// DELIMITER //

// CREATE PROCEDURE UpdateGebruiker(
//     IN p_Id INT,
//     IN p_PersonId INT,
//     IN p_ContactId INT,
//     IN p_Username VARCHAR(100),
//     IN p_Password VARCHAR(255),
//     IN p_UpdatedAt DATETIME
// )
// BEGIN
//     UPDATE user
//     SET 
//         PersonId = p_PersonId,
//         ContactId = p_ContactId,
//         Username = p_Username,
//         Password = p_Password,
//     WHERE Id = p_Id;
// END//

// DELIMITER ;
//         ');
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         // Drop the stored procedure
//         DB::unprepared('DROP PROCEDURE IF EXISTS UpdateGebruiker');
//     }
// };
