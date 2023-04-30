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
        Schema::create('cancel_appintments', function (Blueprint $table) {
            $table->id();
            $table->string('justificacion')->nullable();
            $table->foreignId('cancelled_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('appoinment_id')->constrained('appoinments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_appintments');
    }
};
