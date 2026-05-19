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
    Schema::create('cost_codes', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // e.g., CC-042, CC-109
        $table->string('activity_name'); // e.g., RCC Footing Concrete Laying
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_codes');
    }
};
