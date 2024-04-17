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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('admin_id')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_iban')->nullable();
            $table->float('commission')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('picture')->nullable();
            $table->timestamps();
        });

        Schema::table('introduces', function (Blueprint $table) {
            $table->foreignId('checkout_id')
                ->nullable()
                ->after('admin_id')
                ->references('id')
                ->on('checkouts')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');

        Schema::table('introduces', function (Blueprint $table) {
            $table->dropForeign('checkout_id');
        });
    }
};
