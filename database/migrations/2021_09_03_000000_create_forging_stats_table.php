<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateForgingStatsTable extends Migration
{
    public function up()
    {
        Schema::create('forging_stats', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('public_key');
            $table->integer('missed_blocks');
            $table->integer('forged_blocks');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forging_stats');
    }
}
