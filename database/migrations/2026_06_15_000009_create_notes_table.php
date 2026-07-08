<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained()->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('devoir');
            $table->decimal('note', 5, 2);
            $table->decimal('note_sur', 5, 2)->default(20);
            $table->string('commentaire')->nullable();
            $table->date('date_evaluation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
