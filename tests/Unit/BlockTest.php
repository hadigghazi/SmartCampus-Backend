<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Block;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;

class BlockTest extends TestCase
{
    public function testIndex()
    {
        $blocks = Mockery::mock(Collection::class);
        $blocks->shouldReceive('get')->andReturn(collect([]));

        $blockModel = Mockery::mock(Block::class);
        $blockModel->shouldReceive('get')->andReturn($blocks);

        $response = $this->getJson('/api/blocks');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore()
    {
        $requestData = [
            'name' => 'Block A',
            'campus_id' => 2,
            'description' => 'Block A description',
        ];

        $block = Mockery::mock(Block::class);
        $block->shouldReceive('create')->with($requestData)->andReturn($block);

        $response = $this->postJson('/api/blocks', $requestData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShow()
    {
        $block = Mockery::mock(Block::class);
        $block->shouldReceive('findOrFail')->with(1)->andReturn($block);

        $response = $this->getJson('/api/blocks/2');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $requestData = [
            'name' => 'Updated Block Name',
            'campus_id' => 2,
            'description' => 'Updated description',
        ];

        $block = Mockery::mock(Block::class);
        $block->shouldReceive('findOrFail')->with(1)->andReturn($block);
        $block->shouldReceive('update')->with($requestData)->andReturn(true);

        $response = $this->putJson('/api/blocks/2', $requestData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $block = Mockery::mock(Block::class);
        $block->shouldReceive('findOrFail')->with(1)->andReturn($block);
        $block->shouldReceive('delete')->andReturn(true);

        $response = $this->deleteJson('/api/blocks/2');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testRestore()
    {
        $block = Mockery::mock(Block::class);
        $block->shouldReceive('withTrashed')->andReturnSelf();
        $block->shouldReceive('findOrFail')->with(1)->andReturn($block);
        $block->shouldReceive('restore')->andReturn(true);

        $response = $this->postJson('/api/blocks/2/restore');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForceDelete()
    {
        $block = Mockery::mock(Block::class);
        $block->shouldReceive('withTrashed')->andReturnSelf();
        $block->shouldReceive('findOrFail')->with(1)->andReturn($block);
        $block->shouldReceive('forceDelete')->andReturn(true);

        $response = $this->deleteJson('/api/blocks/2/force-delete');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGetBlocksByCampus()
    {
        $blocks = Mockery::mock(Collection::class);
        $blocks->shouldReceive('where')->with('campus_id', 2)->andReturnSelf();
        $blocks->shouldReceive('get')->andReturn(collect([]));

        $response = $this->getJson('/api/blocks-by-campus/2');
        $response->assertStatus(Response::HTTP_OK);
    }
}
