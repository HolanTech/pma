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
        Schema::create('otb_persite_n_to_ns', function (Blueprint $table) {
            $table->id();
            $table->string('core');
            $table->string('description1');
            $table->string('status_port');
            $table->string('internal')->nullable();
            $table->string('customer')->nullable();
            $table->string('so')->nullable();
            $table->string('cid')->nullable();
            $table->string('description2')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otb_persite_n_to_ns');
    }
};
