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
            $table->string('timestamp')->primary();
            $table->string('public_key');
            $table->boolean('forged');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forging_stats');
    }
}
