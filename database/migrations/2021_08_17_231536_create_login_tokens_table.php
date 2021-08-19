<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('login_tokens');
        Schema::create('login_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->string('token')->unique();
            $table->timestamp('consumed_at')->nullable();
            $table->timestamp('expires_at')->useCurrent();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_tokens');
    }
}
