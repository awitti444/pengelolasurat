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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_type_id'); // Foreign key
            $table->string('letter_perihal');
            $table->json('recipients');
            $table->text('content');
            $table->string('attachment')->nullable(); // Nullable string
            $table->unsignedBigInteger('notulis_id')->nullable(); // Nullable foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
