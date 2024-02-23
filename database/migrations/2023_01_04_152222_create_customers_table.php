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
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->enum('gender', ['L', 'P']);
            $table->string('phone')->nullable();
            $table->enum('type', ['Harian', 'Mingguan', 'Bulanan']);
            $table->string('debt');
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');

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
