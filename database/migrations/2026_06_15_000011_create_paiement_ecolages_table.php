<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiement_ecolages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained()->cascadeOnDelete();
            $table->foreignId('annee_scolaire_id')->constrained()->cascadeOnDelete();
            $table->decimal('montant', 12, 2);
            $table->integer('mois_concerne');
            $table->date('date_paiement');
            $table->string('statut')->default('paye');
            $table->string('mode_paiement')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('montant_restant', 12, 2)->default(0);
            $table->text('remarques')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiement_ecolages');
    }
};
