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
        Schema::table('inboxes', function (Blueprint $table) {
            $table->foreignId('checkOut_id')->after('type_id')->nullable()
                ->references('id')->on('checkout_types')
                ->restrictOnDelete()->cascadeOnUpdate();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('vodaphone')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inboxes', function (Blueprint $table) {
            $table->dropForeign('checkOut_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('vodaphone');
        });
    }
};
