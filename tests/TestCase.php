<?php

namespace Zhelyazko777\Forms\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Home;
use Zhelyazko777\Forms\Tests\TestClasses\HomeOwner;
use Zhelyazko777\Forms\Tests\TestClasses\Owner;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;
use Zhelyazko777\Forms\Tests\TestClasses\OwnerPet;
use Zhelyazko777\Forms\Tests\TestClasses\PetType;
use Zhelyazko777\Forms\Tests\TestClasses\Toy;

class TestCase extends BaseTestCase
{
    protected function setUpDb()
    {
        $this->migrateDb();
        $this->seedDb();
    }

    private function seedDb(): void
    {
        PetType::insert([
            ['id' => 1, 'name' => 'Dog'],
            ['id' => 2, 'name' => 'Cat'],
            ['id' => 3, 'name' => 'Mouse'],
        ]);

        Pet::insert([
            ['id' => 1, 'name' => 'Max', 'age' => 20, 'is_trained' => true, 'pet_type_id' => 1, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['id' => 2, 'name' => 'Richard', 'age' => 1, 'is_trained' => false, 'pet_type_id' => 1, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['id' => 3, 'name' => 'Vivi', 'age' => 10, 'is_trained' => true, 'pet_type_id' => 3, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['id' => 4, 'name' => 'Mani', 'age' => 4, 'is_trained' => false, 'pet_type_id' => 2, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['id' => 5, 'name' => 'Bob', 'age' => 8,'is_trained' => true, 'pet_type_id' => 2, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
            ['id' => 6, 'name' => 'Rambo', 'age' => 1, 'is_trained' => true, 'pet_type_id' => 1, 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => now()],
        ]);

        Toy::insert([
            ['id' => 1, 'name' => 'Ball 1', 'pet_id' => 1],
            ['id' => 2, 'name' => 'Ball 2', 'pet_id' => 3],
            ['id' => 3, 'name' => 'Ball 3', 'pet_id' => 2],
            ['id' => 4, 'name' => 'Ball Null 1', 'pet_id' => null],
            ['id' => 5, 'name' => 'Ball Null 2', 'pet_id' => null],
        ]);

        Owner::insert([
            [ 'id' => 1, 'name' => 'Max' ],
            [ 'id' => 2, 'name' => 'Aidan' ],
            [ 'id' => 3, 'name' => 'Richard' ],
            [ 'id' => 4, 'name' => 'Ben' ],
        ]);

        OwnerPet::insert([
            [ 'id' => 1, 'pet_id' => 1, 'owner_id' => 1, 'updated_at' => now(), 'created_at' => now(), 'deleted_at' => null ],
            [ 'id' => 2, 'pet_id' => 2, 'owner_id' => 1, 'updated_at' => now(), 'created_at' => now(), 'deleted_at' => null ],
            [ 'id' => 3, 'pet_id' => 3, 'owner_id' => 1, 'updated_at' => now(), 'created_at' => now(), 'deleted_at' => now() ],
            [ 'id' => 4, 'pet_id' => 4, 'owner_id' => 2, 'updated_at' => now(), 'created_at' => now(), 'deleted_at' => null ],
            [ 'id' => 5, 'pet_id' => 5, 'owner_id' => 3, 'updated_at' => now(), 'created_at' => now(), 'deleted_at' => null ],
            [ 'id' => 6, 'pet_id' => 6, 'owner_id' => 4, 'updated_at' => now(), 'created_at' => now(), 'deleted_at' => now() ],
        ]);

        Home::insert([
            [ 'id' => 1, 'name' => 'Home 1', ],
            [ 'id' => 2, 'name' => 'Home 2', ],
            [ 'id' => 3, 'name' => 'Home 3', ],
            [ 'id' => 4, 'name' => 'Home 4', ],
        ]);

        HomeOwner::insert([
            ['id' => 1, 'owner_id' => 2, 'home_id' => 3],
            ['id' => 2, 'owner_id' => 3, 'home_id' => 1],
            ['id' => 3, 'owner_id' => 2, 'home_id' => 1],
        ]);
    }

    private function migrateDb(): void
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
            $table->boolean('is_trained');
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

        \Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        \Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        \Schema::create('owner_pet', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('owner_id')
                ->constrained('owners');
            $table
                ->foreignId('pet_id')
                ->constrained('pets');
            $table->timestamps();
            $table->softDeletes();
        });

        \Schema::create('home_owner', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('owner_id')
                ->constrained('owners');
            $table
                ->foreignId('home_id')
                ->constrained('homes');
            $table->timestamps();
            $table->softDeletes();
        });

    }
}