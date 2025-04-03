<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // CREATE TABLE users (
        //     id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        //     username VARCHAR(50) UNIQUE NOT NULL,
        //     email VARCHAR(100) UNIQUE NOT NULL,
        //     password TEXT NOT NULL,
        //     role VARCHAR(50) CHECK (role IN ('admin', 'customer', 'warehouse_manager', 'staff')),
        //     first_name VARCHAR(50),
        //     last_name VARCHAR(50),
        //     address TEXT,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        //     ); 
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->text('password');
            $table->enum('role', ['admin', 'customer', 'warehouse_manager', 'staff']);
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};