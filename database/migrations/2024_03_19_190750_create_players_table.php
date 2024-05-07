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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->unsignedInteger('age');
            $table->decimal('market_price', 10, 2);
            $table->foreignIdFor(\App\Models\Country::class)->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Position::class)->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Team::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
