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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->index()->unique();
            $table->string('password', 100)->nullable();
            $table->string('full_name', 100)->nullable();
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_active')->default(1);
            $table->dateTime('last_paid_at')->comment('Last paid date')->nullable();
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
        Schema::dropIfExists('users');
    }
};
