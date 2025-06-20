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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('department');
            $table->string('location');
            $table->string('employment_type'); // Full-time, Part-time, Contract
            $table->text('requirements');
            $table->text('responsibilities');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
