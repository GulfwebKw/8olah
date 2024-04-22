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
        Schema::create('checkout_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->timestamps();
        });
        Schema::table('checkouts', function (Blueprint $table) {
            $table->foreignId('checkout_type_id')->nullable()->references('id')->on('checkout_types')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_types');
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropForeign('checkout_type_id');
        });
    }
};
