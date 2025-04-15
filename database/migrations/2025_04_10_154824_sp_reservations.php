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
        // Create Stored Procedure: Get all reservations
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_get_all_reservations`;
            CREATE PROCEDURE `sp_get_all_reservations`()
            BEGIN
                SELECT 
                    r.id, r.customerId, r.timeslotId, r.courtId, r.date, 
                    r.minutes, r.status, r.numberOfPeople, r.isActive, 
                    r.note, r.createdAt, r.updatedAt,
                    c.number as courtNumber,
                    t.startTime, t.endTime
                FROM reservation r
                JOIN court c ON r.courtId = c.id
                JOIN timeslot t ON r.timeslotId = t.id
                WHERE r.isActive = 1
                ORDER BY r.date, t.startTime;
            END
        ');

        // Create Stored Procedure: Get reservation by ID
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_get_reservation_by_id`;
            CREATE PROCEDURE `sp_get_reservation_by_id`(IN reservation_id INT)
            BEGIN
                SELECT 
                    r.id, r.customerId, r.timeslotId, r.courtId, r.date, 
                    r.minutes, r.status, r.numberOfPeople, r.isActive, 
                    r.note, r.createdAt, r.updatedAt,
                    c.number as courtNumber,
                    t.startTime, t.endTime,
                    p.firstName, p.infix, p.lastName
                FROM reservation r
                JOIN court c ON r.courtId = c.id
                JOIN timeslot t ON r.timeslotId = t.id
                JOIN customer cu ON r.customerId = cu.id
                JOIN person p ON cu.personId = p.id
                WHERE r.id = reservation_id;
            END
        ');

        // Create Stored Procedure: Get reservations by customer ID
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_get_reservations_by_customer`;
            CREATE PROCEDURE `sp_get_reservations_by_customer`(IN customer_id INT)
            BEGIN
                SELECT 
                    r.id, r.customerId, r.timeslotId, r.courtId, r.date, 
                    r.minutes, r.status, r.numberOfPeople, r.isActive, 
                    r.note, r.createdAt, r.updatedAt,
                    c.number as courtNumber,
                    t.startTime, t.endTime
                FROM reservation r
                JOIN court c ON r.courtId = c.id
                JOIN timeslot t ON r.timeslotId = t.id
                WHERE r.customerId = customer_id AND r.isActive = 1
                ORDER BY r.date, t.startTime;
            END
        ');
        
        // Create Stored Procedure: Create new reservation
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_create_reservation`;
            CREATE PROCEDURE `sp_create_reservation`(
                IN p_customerId INT,
                IN p_courtId INT,
                IN p_timeslotId INT,
                IN p_date DATE,
                IN p_minutes INT,
                IN p_status VARCHAR(50),
                IN p_numberOfPeople INT,
                IN p_note VARCHAR(255)
            )
            BEGIN
                DECLARE reservation_exists INT DEFAULT 0;
                
                -- Check if the court is already reserved for this time slot on this date
                SELECT COUNT(*) INTO reservation_exists 
                FROM reservation
                WHERE courtId = p_courtId 
                AND timeslotId = p_timeslotId 
                AND date = p_date 
                AND isActive = 1;
                
                IF reservation_exists = 0 THEN
                    INSERT INTO reservation (
                        customerId, courtId, timeslotId, date,
                        minutes, status, numberOfPeople, note,
                        isActive, createdAt, updatedAt
                    ) VALUES (
                        p_customerId, p_courtId, p_timeslotId, p_date,
                        p_minutes, p_status, p_numberOfPeople, p_note,
                        1, NOW(), NOW()
                    );
                    
                    SELECT LAST_INSERT_ID() AS reservation_id, "Reservation created successfully" AS message;
                ELSE
                    SELECT 0 AS reservation_id, "Court is already reserved for this time slot" AS message;
                END IF;
            END
        ');

        // Create Stored Procedure: Update reservation
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_update_reservation`;
            CREATE PROCEDURE `sp_update_reservation`(
                IN p_reservation_id INT,
                IN p_courtId INT,
                IN p_timeslotId INT,
                IN p_date DATE,
                IN p_minutes INT,
                IN p_status VARCHAR(50),
                IN p_numberOfPeople INT,
                IN p_note VARCHAR(255)
            )
            BEGIN
                DECLARE reservation_exists INT DEFAULT 0;
                
                -- Check if the court is already reserved for this time slot on this date (excluding current reservation)
                SELECT COUNT(*) INTO reservation_exists 
                FROM reservation
                WHERE courtId = p_courtId 
                AND timeslotId = p_timeslotId 
                AND date = p_date 
                AND isActive = 1
                AND id != p_reservation_id;
                
                IF reservation_exists = 0 THEN
                    UPDATE reservation
                    SET 
                        courtId = p_courtId,
                        timeslotId = p_timeslotId,
                        date = p_date,
                        minutes = p_minutes,
                        status = p_status,
                        numberOfPeople = p_numberOfPeople,
                        note = p_note,
                        updatedAt = NOW()
                    WHERE id = p_reservation_id;
                    
                    SELECT p_reservation_id AS reservation_id, "Reservation updated successfully" AS message;
                ELSE
                    SELECT 0 AS reservation_id, "Court is already reserved for this time slot" AS message;
                END IF;
            END
        ');

        // Create Stored Procedure: Cancel reservation (soft delete)
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_cancel_reservation`;
            CREATE PROCEDURE `sp_cancel_reservation`(IN reservation_id INT)
            BEGIN
                UPDATE reservation
                SET 
                    isActive = 0,
                    status = "canceled",
                    updatedAt = NOW()
                WHERE id = reservation_id;
                
                SELECT reservation_id, "Reservation canceled successfully" AS message;
            END
        ');

        // Create Stored Procedure: Check court availability
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_check_court_availability`;
            CREATE PROCEDURE `sp_check_court_availability`(
                IN p_date DATE,
                IN p_timeslotId INT
            )
            BEGIN
                SELECT 
                    c.id, c.number,
                    CASE 
                        WHEN r.id IS NULL THEN "Available" 
                        ELSE "Reserved" 
                    END AS status
                FROM court c
                LEFT JOIN (
                    SELECT * FROM reservation 
                    WHERE date = p_date AND timeslotId = p_timeslotId AND isActive = 1
                ) r ON c.id = r.courtId
                WHERE c.isActive = 1
                ORDER BY c.number;
            END
        ');
        
        // Create Stored Procedure: Get reservations by date
        DB::unprepared('
            DROP PROCEDURE IF EXISTS `sp_get_reservations_by_date`;
            CREATE PROCEDURE `sp_get_reservations_by_date`(IN reservation_date DATE)
            BEGIN
                SELECT 
                    r.id, r.customerId, r.timeslotId, r.courtId, r.date, 
                    r.minutes, r.status, r.numberOfPeople, r.isActive, 
                    r.note, r.createdAt, r.updatedAt,
                    c.number as courtNumber,
                    t.startTime, t.endTime,
                    CONCAT(p.firstName, " ", IFNULL(p.infix, ""), " ", p.lastName) as customerName
                FROM reservation r
                JOIN court c ON r.courtId = c.id
                JOIN timeslot t ON r.timeslotId = t.id
                JOIN customer cu ON r.customerId = cu.id
                JOIN person p ON cu.personId = p.id
                WHERE r.date = reservation_date AND r.isActive = 1
                ORDER BY t.startTime, c.number;
            END
        ');

        DB::unprepared('
            DROP PROCEDURE IF EXISTS `GetReserveringOverzicht`;
            CREATE PROCEDURE GetReserveringOverzicht(IN p_datum DATE)
            BEGIN
                SELECT 
                    CONCAT(p.firstName, " ", IFNULL(p.infix, ""), " ", p.lastName) AS Naam,
                    r.date AS Reserveringsdatum,
                    r.minutes AS Uren,
                    r.numberOfPeople AS Volwassenen,
                    r.courtId AS BaanNummer, -- Ensure this alias matches the expected property
                    r.status AS Status
                FROM 
                    person p
                INNER JOIN 
                    customer cu ON p.id = cu.personId
                INNER JOIN 
                    reservation r ON cu.id = r.customerId
                WHERE 
                    r.date <= p_datum -- Filter by the provided date
                ORDER BY 
                    r.date DESC, r.createdAt ASC;
            END
        ');

        DB::unprepared('
            DROP PROCEDURE IF EXISTS `GetReserveringDetails`;
            CREATE PROCEDURE GetReserveringDetails(IN reservering_id INT)
            BEGIN
                SELECT 
                    CONCAT(p.firstName, " ", IFNULL(p.infix, ""), " ", p.lastName) AS Naam,
                    r.date AS Reserveringsdatum,
                    r.numberOfPeople AS Volwassenen,
                    r.courtId AS BaanNummer, -- Ensure this alias matches the expected property
                    t.startTime AS Starttijd,
                    t.endTime AS Eindtijd,
                    r.status AS Status
                FROM 
                    person p
                INNER JOIN 
                    customer cu ON p.id = cu.personId
                INNER JOIN 
                    reservation r ON cu.id = r.customerId
                INNER JOIN 
                    timeslot t ON r.timeslotId = t.id
                WHERE 
                    r.id = reservering_id;
            END
        ');
    }

    /**
     * Reverse the migrations. 
     */
    public function down(): void
    {
        // Drop all stored procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_all_reservations`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_reservation_by_id`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_reservations_by_customer`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_create_reservation`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_update_reservation`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_cancel_reservation`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_check_court_availability`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_reservations_by_date`');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetReserveringOverzicht');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetReserveringDetails');
        // Drop all tables
        
    }
};
