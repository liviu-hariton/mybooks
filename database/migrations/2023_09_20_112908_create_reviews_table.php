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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_id');

            $table->text('review');
            $table->unsignedTinyInteger('rating');

            $table->timestamps();

            $table->foreign('book_id') // this table
                ->references('id') // parent table primary key
                ->on('books') // parent table name
                ->onDelete('cascade');

            // alternative way to assign parent table, with Laravel defaults
            /*$table->foreignId('book_id')
                ->constrained()
                ->cascadeOnDelete();*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
