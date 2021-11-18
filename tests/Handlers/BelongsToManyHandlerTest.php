<?php

namespace Zhelyazko777\Forms\Tests\Handlers;

use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Handlers\BelongsToManyHandler;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\OwnerPet;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class BelongsToManyHandlerTest extends TestCase
{
    private BelongsToManyHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new BelongsToManyHandler;
        $this->setUpDb();
    }

    public function test_handle_should_hard_delete_connections_if_empty_connections_array_passed_and_no_soft_delete_specified()
    {
        $model = Pet::find(2);
        $config = (new MultiselectFormControlConfig)->setName('owners');

        $this->handler->handle($config, $model, 'owners', []);

        $this->assertEmpty($model->fresh()->ownersWithSoftDeleted);
    }

    public function test_handle_should_hard_delete_connections_removed_connections_and_add_new_ones()
    {
        $ownerIds = [3,4];
        $model = Pet::find(2);
        $config = (new MultiselectFormControlConfig)->setName('owners');

        $this->handler->handle($config, $model, 'owners', $ownerIds);

        $ownerPets = OwnerPet::where('pet_id', $model->id)->orderBy('pet_id')->get();
        $this->assertCount(2, $ownerPets);
        $this->assertEquals(3, $ownerPets[0]->owner_id);
        $this->assertEquals(4, $ownerPets[1]->owner_id);
    }

    public function test_handle_should_soft_delete_connections_if_empty_connections_array_passed_and_soft_delete_specified()
    {
        $model = Pet::find(2);
        $config = (new MultiselectFormControlConfig)
            ->setName('owners')
            ->setSoftDeleteConnections(true);

        $this->handler->handle($config, $model, 'owners', []);

        $ownersWithSoftDeleted = $model
            ->fresh()
            ->ownersWithSoftDeleted()
            ->get(['owner_pet.id AS id', 'owner_pet.deleted_at AS deleted_at']);
        $this->assertEmpty($model->fresh()->owners);
        $this->assertCount(1, $ownersWithSoftDeleted);
        $this->assertNotNull($ownersWithSoftDeleted[0]->deleted_at);
    }

    public function test_handle_with_soft_delete_should_soft_delete_connections_removed_connections_and_add_new_ones()
    {
        $ownerIds = [3,4];
        $model = Pet::find(2);
        $config = (new MultiselectFormControlConfig)
            ->setName('owners')
            ->setSoftDeleteConnections(true);

        $this->handler->handle($config, $model, 'owners', $ownerIds);

        $ownerPets = OwnerPet::query()->where('pet_id', $model->id)
            ->orderBy('pet_id')
            ->get();
        $this->assertCount(3, $ownerPets);
        $this->assertEquals(1, $ownerPets[0]->owner_id);
        $this->assertNotNull($ownerPets[0]->deleted_at);
        $this->assertEquals(3, $ownerPets[1]->owner_id);
        $this->assertEquals(4, $ownerPets[2]->owner_id);
    }

    public function test_handle_with_soft_delete_when_addded_soft_deleted_connection_should_restore_old_one_instead_of_making_new()
    {
        $ownerIds = [1];
        $model = Pet::find(3);
        $config = (new MultiselectFormControlConfig)
            ->setName('owners')
            ->setSoftDeleteConnections(true);

        $this->handler->handle($config, $model, 'owners', $ownerIds);

        $ownerPets = OwnerPet::query()->where('pet_id', $model->id)->get();
        $this->assertCount(1, $ownerPets);
        $this->assertEquals(1, $ownerPets[0]->owner_id);
        $this->assertNull($ownerPets[0]->deleted_at);
    }
}