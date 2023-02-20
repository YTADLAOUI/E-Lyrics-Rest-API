<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->foreignId('artist_ID')
                ->constrained('artists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('album_ID')
                ->constrained('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_ID')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            //
        });
    }
};
