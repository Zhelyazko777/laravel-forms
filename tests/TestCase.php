<?php

namespace Zhelyazko777\Forms\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;
use Zhelyazko777\Forms\Tests\TestClasses\PetType;
use Zhelyazko777\Forms\Tests\TestClasses\Toy;

class TestCase extends BaseTestCase
{
    protected function set_up_db()
    {
        $this->migrate_db();
        $this->seed_db();
    }

    private function seed_db(): void
    {
        PetType::insert([
            ['name' => 'Dog'],
            ['name' => 'Cat'],
            ['name' => 'Mouse'],
        ]);

        Pet::insert([
            ['name' => 'Max', 'age' => 20, 'pet_type_id' => 1, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['name' => 'Richard', 'age' => 1, 'pet_type_id' => 1, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['name' => 'Vivi', 'age' => 10, 'pet_type_id' => 3, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['name' => 'Mani', 'age' => 4, 'pet_type_id' => 2, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['name' => 'Bob', 'age' => 8, 'pet_type_id' => 2, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['name' => 'Rambo', 'age' => 1, 'pet_type_id' => 1, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
        ]);

        Toy::insert([
            ['name' => 'Ball 1', 'pet_id' => 1],
            ['name' => 'Ball 2', 'pet_id' => 2],
            ['name' => 'Ball 3', 'pet_id' => 3],
            ['name' => 'Ball Null 1', 'pet_id' => null],
            ['name' => 'Ball Null 2', 'pet_id' => null],
        ]);
    }

    private function migrate_db(): void
    {
        \Schema::dropAllTables();

        \Schema::create('pet_types', function (Blueprint $table)  {
            $table->id();
            $table->string('name');
        });

        \Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table
                ->foreignId('pet_type_id')
                ->constrained('pet_types');
            $table->timestamps();
            $table->softDeletes();
        });

        \Schema::create('toys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table
                ->foreignId('pet_id')
                ->nullable()
                ->constrained('pets');
            $table->softDeletes();
        });
    }
}