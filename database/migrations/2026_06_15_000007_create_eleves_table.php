<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained()->cascadeOnDelete();
            $table->string('matricule');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('sexe')->default('M');
            $table->string('nationalite')->nullable();
            $table->string('adresse')->nullable();
            $table->string('photo')->nullable();
            $table->string('nom_parent');
            $table->string('prenom_parent')->nullable();
            $table->string('telephone_parent');
            $table->string('email_parent')->nullable();
            $table->string('profession_parent')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->text('allergies')->nullable();
            $table->text('remarques')->nullable();
            $table->date('date_inscription');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['etablissement_id', 'matricule']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
