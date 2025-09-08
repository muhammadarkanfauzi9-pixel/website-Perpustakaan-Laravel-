<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('book_img'); // Sesuai permintaan, menggunakan string
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('shelf_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->string('title');

            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->foreign('shelf_id')->references('id')->on('shelves');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
