<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('besuk_tahanan', function (Blueprint $table) {
            $table->unsignedBigInteger('tahanan_id')->nullable()->after('id');
            $table->foreign('tahanan_id')
                  ->references('id')
                  ->on('data_tahanan')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('besuk_tahanan', function (Blueprint $table) {
            $table->dropForeign(['tahanan_id']);
            $table->dropColumn('tahanan_id');
        });
    }
};