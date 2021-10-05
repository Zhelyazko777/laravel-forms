<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table
                ->foreignId('owner_id')
                ->constrained('owners');
        });

        Schema::create('dog_toy', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('dog_id')
                ->constrained('dogs');
            $table
                ->foreignId('toy_id')
                ->constrained('toys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_toy');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('dogs');
        Schema::dropIfExists('toys');
    }
}
