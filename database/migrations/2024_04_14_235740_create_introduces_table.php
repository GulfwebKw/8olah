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
        Schema::create('introduces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('admin_id')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('description')->nullable();
            $table->text('admin_description')->nullable();
            $table->integer('number_works')->nullable();
            $table->integer('number_works_api')->nullable();
            $table->integer('number_works_approved')->nullable();
            $table->float('earn_commission')->nullable();
            $table->boolean('is_earned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('introduces');
    }
};
