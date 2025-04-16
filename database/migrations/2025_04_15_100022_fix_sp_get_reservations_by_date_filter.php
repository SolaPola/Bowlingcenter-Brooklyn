<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        DROP PROCEDURE IF EXISTS `sp_get_reservations_by_date_filter`;
        CREATE PROCEDURE `sp_get_reservations_by_date_filter`(IN reservation_date DATE)
        BEGIN
            SELECT 
                r.id
                ,r.customerId
                ,r.timeslotId
                ,r.courtId
                ,r.date
                ,r.minutes
                ,r.status
                ,r.AantalVolwassenen
                ,r.AantalKinderen
                ,r.isActive 
                ,r.note
                ,r.createdAt
                ,r.updatedAt
                ,c.number as courtNumber
                ,t.startTime 
                ,t.endTime
                ,p.firstName as firstName
                ,p.infix as infix
                ,p.lastName as lastName
            FROM reservation as r

            INNER JOIN court as c 
            ON r.courtId = c.id

            INNER JOIN timeslot as t 
            ON r.timeslotId = t.id

            INNER JOIN customer as cu 
            ON r.customerId = cu.id

            INNER JOIN person AS p
            ON cu.personId = p.id

            LEFT JOIN `order` as orders
            ON orders.reservationId = r.id
            WHERE 
                -- Match the reservation date
                r.date >= reservation_date 
                -- Only include active reservations
                AND r.isActive = 1
                -- Exclude canceled reservations
                AND r.status != "Geannuleerd"

            ORDER BY r.date ASC;
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
