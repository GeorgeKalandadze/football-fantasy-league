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
        Schema::create('fantasy_team_players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Player::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\FantasyTeam::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fantasy_team_players');
    }
};
