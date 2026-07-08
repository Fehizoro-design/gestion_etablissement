<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nom');
            $table->string('type')->default('autre');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('site_web')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('devise')->nullable();
            $table->string('code_etablissement')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('etablissement_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('proprietaire');
            $table->timestamps();

            $table->unique(['etablissement_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etablissement_user');
        Schema::dropIfExists('etablissements');
    }
};
