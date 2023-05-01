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
        Schema::table('cancel_appintments', function (Blueprint $table) {
            $table->renameColumn('cancelled_by','cancelled_by_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cancel_appintments', function (Blueprint $table) {
            $table->renameColumn('cancelled_by_id','cancelled_by');
        });
    }
};
