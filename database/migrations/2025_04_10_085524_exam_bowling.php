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
        Schema::create('persoon', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('voornaam', 100);
            $table->string('tussenvoegsel', 50)->nullable();
            $table->string('achternaam', 100);
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('contact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('email', 255)->unique();
            $table->string('telefoonnummer', 15)->nullable();
            $table->string('adres', 255)->nullable();
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('gebruiker', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('persoonId')->constrained('persoon');
            $table->foreignId('contactId')->constrained('contact');
            $table->string('gebruikersnaam', 100)->unique();
            $table->string('wachtwoord', 255);
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('rol', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('gebruikerId')->constrained('gebruiker');
            $table->string('naam', 50);
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('medewerker', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('persoonId')->constrained('persoon');
            $table->string('functie', 100)->nullable();
            $table->string('afdeling', 100)->nullable();
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('score', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->integer('aantal', false, true)->length(20);
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('klant', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('persoonId')->constrained('persoon');
            $table->foreignId('scoreId')->constrained('score');
            $table->string('lidmaatschapType', 50)->nullable();
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('tijdstip', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->time('starttijd');
            $table->time('eindtijd');
            $table->string('dag', 20);
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('baan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->integer('nummer')->unique();
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('reservering', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('klantId')->constrained('klant');
            $table->foreignId('tijdstipId')->constrained('tijdstip');
            $table->foreignId('baanId')->constrained('baan');
            $table->date('datum');
            $table->integer('minuten');
            $table->string('status', 50);
            $table->integer('aantalPersonen')->nullable();
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });

        Schema::create('bestelling', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('reserveringId')->constrained('reservering');
            $table->integer('bestellingsnummer');
            $table->date('bestellingsdatum');
            $table->boolean('isActief')->default(true);
            $table->string('opmerking', 255)->nullable();
            $table->dateTime('datumAangemaakt', 6);
            $table->dateTime('datumGewijzigd', 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bestelling');
        Schema::dropIfExists('reservering');
        Schema::dropIfExists('baan');
        Schema::dropIfExists('tijdstip');
        Schema::dropIfExists('klant');
        Schema::dropIfExists('score');
        Schema::dropIfExists('medewerker');
        Schema::dropIfExists('rol');
        Schema::dropIfExists('gebruiker');
        Schema::dropIfExists('contact');
        Schema::dropIfExists('persoon');
    }
};