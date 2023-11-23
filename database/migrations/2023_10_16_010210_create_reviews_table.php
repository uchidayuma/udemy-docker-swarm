<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('recipe_id');
            // $table->foreignUuId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignUuId('recipe_id')->constrained()->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletes();
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
