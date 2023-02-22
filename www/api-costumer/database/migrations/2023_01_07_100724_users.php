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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid',120)->nullable(false)->unique();
            $table->string('email',120)->nullable(false)->unique()->index('idx_cust_email');
            $table->string('name',160)->nullable(false);
            $table->text('password')->nullable(false);
            $table->char('gender',1)->nullable();
            $table->tinyInteger('is_married')->default(0);
            $table->text('address')->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('customers');
    }
};
