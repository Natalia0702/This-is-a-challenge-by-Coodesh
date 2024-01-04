<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('access_level', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('expense_id')->constrained();
            $table->unsignedTinyInteger('access_level')->nullable(); 
            $table->timestamps();
        });

        DB::statement("ALTER TABLE access_level ADD CONSTRAINT check_access_level CHECK (access_level IN (1, 2))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_level');
    }
};
