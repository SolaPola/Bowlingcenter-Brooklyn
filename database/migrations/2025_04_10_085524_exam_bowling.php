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
        Schema::create('typePerson', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('naam', 100);
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('person', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('typePerson_id')->nullable()->constrained('typePerson'); // Make it nullable
            $table->string('firstName', 100);
            $table->string('infix', 50)->nullable();
            $table->string('lastName', 100);
            $table->string('nickname', 50)->nullable();
            $table->boolean('isAdult');
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('contact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('personId')->constrained('person');
            $table->string('email', 255)->unique();
            $table->string('phoneNumber', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('userId')->constrained('users');
            $table->string('name', 50);
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('employee', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('personId')->constrained('person');
            $table->string('function', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('score', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->integer('amount', false, true)->length(20);
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('customer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('personId')->constrained('person');
            $table->foreignId('scoreId')->constrained('score');
            $table->string('membershipType', 50)->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('timeslot', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->time('startTime');
            $table->time('endTime');
            $table->string('day', 20);
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('court', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->integer('number')->unique();
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('reservation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('customerId')->constrained('customer');
            $table->foreignId('timeslotId')->constrained('timeslot');
            $table->foreignId('courtId')->constrained('court');
            $table->date('date');
            $table->integer('minutes');
            $table->string('status', 50);
            $table->integer('numberOfPeople')->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('reservationId')->constrained('reservation');
            $table->integer('orderNumber');
            $table->date('orderDate');
            $table->string('packageType');
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('persoon', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('TypePersoon', 20);
            $table->string('Voornaam', 50);
            $table->string('Tussenvoegsel', 20)->nullable();
            $table->string('Achternaam', 50);
            $table->string('Roepnaam', 50)->nullable();
            $table->boolean('IsVolwassen');
            $table->timestamps(6);
        });

        Schema::create('reservering', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('PersoonId')->constrained('persoon');
            $table->foreignId('OpeningstijdId'); // Add foreign key constraint if applicable
            $table->foreignId('BaanId'); // Add foreign key constraint if applicable
            $table->integer('PakketOptieId')->nullable();
            $table->string('ReserveringStatus', 20);
            $table->string('Reserveringsnummer', 20);
            $table->date('Datum');
            $table->integer('AantalUren');
            $table->time('BeginTijd');
            $table->time('EindTijd');
            $table->integer('AantalVolwassen');
            $table->integer('AantalKinderen')->nullable();
            $table->timestamps(6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('reservation');
        Schema::dropIfExists('court');
        Schema::dropIfExists('timeslot');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('score');
        Schema::dropIfExists('employee');
        Schema::dropIfExists('role');
        Schema::dropIfExists('contact');
        Schema::dropIfExists('person');
        Schema::dropIfExists('typePerson');
        Schema::dropIfExists('persoon');
        Schema::dropIfExists('reservering');
    }
};
