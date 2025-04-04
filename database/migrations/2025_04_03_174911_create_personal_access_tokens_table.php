<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('token');
            $table->json('abilities')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->uuid('tokenable_id');
            $table->string('tokenable_type');
            $table->timestamps();
    
            // Foreign key constraint (if needed)
            $table->foreign('tokenable_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};