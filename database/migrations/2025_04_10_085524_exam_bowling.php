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
        Schema::create('person', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('firstName', 100);
            $table->string('infix', 50)->nullable();
            $table->string('lastName', 100);
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('contact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->string('email', 255)->unique();
            $table->string('phoneNumber', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->engine = 'InnoDB';
            $table->foreignId('contactId')->nullable()->constrained('contact')->onDelete('cascade');
            $table->foreignId('personId')->nullable()->constrained('person')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('email')->unique()->after('name');
            $table->string('password');
            $table->boolean('is_logged_in')->default(false);
            $table->timestamp('logged_in')->nullable();
            $table->timestamp('logged_out')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
            $table->timestamps();
        });

        Schema::create('employee', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id()->unsigned();
            $table->foreignId('personId')->constrained('person');
            $table->string('function', 100)->nullable();
            $table->enum('employee_type', ['Manager', 'Administrator', 'Desk Employee']);
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
            $table->boolean('isActive')->default(true);
            $table->string('note', 255)->nullable();
            $table->dateTime('createdAt', 6);
            $table->dateTime('updatedAt', 6);
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
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
