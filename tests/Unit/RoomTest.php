<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Room;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;

class RoomTest extends TestCase
{
    public function testIndex()
    {
        $rooms = Mockery::mock(Collection::class);
        $rooms->shouldReceive('get')->andReturn(collect([]));

        $roomModel = Mockery::mock(Room::class);
        $roomModel->shouldReceive('get')->andReturn($rooms);

        $response = $this->getJson('/api/rooms');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'number' => '101',
            'block_id' => 3,
            'capacity' => 30,
            'description' => 'Room 101 description',
        ];

        $room = Mockery::mock(Room::class);
        $room->shouldReceive('create')->with($requestData)->andReturn($room);

        $response = $this->postJson('/api/rooms', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $room = Mockery::mock(Room::class);
        $room->shouldReceive('findOrFail')->with(1)->andReturn($room);

        $response = $this->getJson('/api/rooms/3');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'number' => '102',
            'block_id' => 3,
            'capacity' => 40,
            'description' => 'Updated description',
        ];

        $room = Mockery::mock(Room::class);
        $room->shouldReceive('findOrFail')->with(1)->andReturn($room);
        $room->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/rooms/3', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $room = Mockery::mock(Room::class);
        $room->shouldReceive('findOrFail')->with(1)->andReturn($room);
        $room->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/rooms/3');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $room = Mockery::mock(Room::class);
        $room->shouldReceive('withTrashed')->andReturnSelf();
        $room->shouldReceive('findOrFail')->with(1)->andReturn($room);
        $room->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/rooms/3/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $room = Mockery::mock(Room::class);
        $room->shouldReceive('withTrashed')->andReturnSelf();
        $room->shouldReceive('findOrFail')->with(1)->andReturn($room);
        $room->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/rooms/3/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetRoomsByBlock()
    {
        $rooms = Mockery::mock(Collection::class);
        $rooms->shouldReceive('where')->with('block_id', 1)->andReturnSelf();
        $rooms->shouldReceive('get')->andReturn(collect([]));

        $response = $this->getJson('/api/rooms-by-block/3');
        $response->assertStatus(Response::HTTP_OK);
    }
}
