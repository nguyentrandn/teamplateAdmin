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
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('customer_type_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('vat_number');
            $table->string('phone');
            $table->json('address');
            $table->tinyInteger('status')->default(config('apps.common.status.active'));
            $table->rememberToken();
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
