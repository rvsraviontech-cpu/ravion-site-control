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
    Schema::create('dpr_logs', function (Blueprint $table) {
        $table->id();
        $table->string('project_name');
        $table->string('work_activity');
        $table->string('cost_code_mapped')->nullable(); 
        $table->string('contractor_name');
        $table->integer('labor_count');
        $table->string('quantity_completed');
        $table->string('material_desc')->nullable();
        $table->integer('material_qty')->nullable();
        $table->string('challan_no')->nullable();
        $table->string('photo_path')->nullable(); 
        $table->string('status')->default('pending_mapping'); // pending_mapping, verified
        $table->timestamps();
    });
}
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpr_logs');
    }
};
