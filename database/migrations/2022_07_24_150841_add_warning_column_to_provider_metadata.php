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
        if (Schema::hasTable('provider_metadata')) {
            Schema::table('provider_metadata', function (Blueprint $table) {
                $table->text('warning')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('provider_metadata') && Schema::hasColumn('provider_metadata', 'warning')) {
            Schema::table('provider_metadata', function (Blueprint $table) {
                $table->dropColumn('warning');
            });
        }
    }
};
