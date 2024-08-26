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
        Schema::create('calculate__amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_amount_id');
            $table->string('name');
            $table->decimal('amount', 10, 2); // Adjust precision and scale as needed
            $table->decimal('due', 10, 2); // Adjust precision and scale as needed
            $table->decimal('extra', 10, 2); // Adjust precision and scale as needed
            $table->timestamps();
            // Set the table engine to InnoDB
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculate__amounts');
    }
};
