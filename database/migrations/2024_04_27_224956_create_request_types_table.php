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
        Schema::create('request_types', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->timestamps();
        });

        Schema::table('inboxes', function (Blueprint $table) {
            $table->foreignId('type_id')->after('user_id')->nullable()
                ->references('id')->on('request_types')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->string('vodaphone')->after('message')->nullable();
        });

        Schema::table('checkouts', function (Blueprint $table) {
            $table->string('vodaphone')->nullable()->after('tracking_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_types');

        Schema::table('inboxes', function (Blueprint $table) {
            $table->dropForeign('type_id');
            $table->dropColumn('vodaphone');
        });

        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn('vodaphone');
        });
    }
};
