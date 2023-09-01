<?php

namespace Tests\Feature;

use App\Http\Resources\CategoryResource;
use App\Models\CategoryCommand;
use App\Models\CategoryQuery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }



    public function test_store_product(): void
    {
        $data = [
            'name' => "Test-Category"
        ];
        $response = $this->post(route('category.add'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'name' => "Test-Category"
            ],
        ]);
        $this->assertDatabaseHas('category_queries', [
            'name' => "Test-Category"
        ]);
        $CategoryCommand = CategoryCommand::latest()->first();
        $CategoryQuery = CategoryQuery::latest()->first();

        $this->assertEquals($CategoryCommand->id, $CategoryQuery->id);
        $this->assertEquals($CategoryCommand->name, $CategoryQuery->name);
    }

    public function test_index_category(): void
    {

        $response = $this->get(route('category.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'data' => [
                        'id',
                        'name',
                    ]
                ]
            ],
        ]);
    }


    public function test_update_product(): void
    {
        $Category = CategoryQuery::latest()->first();
        $data = [
            'name' => "Test-Category-Update"
        ];
        $response = $this->post(route('category.update', ['category' => $Category->id]), $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'name' => "Test-Category-Update"
            ],
        ]);
        $this->assertDatabaseHas('category_queries', [
            'name' => "Test-Category-Update"
        ]);
        $CategoryCommand = CategoryCommand::where('id', $Category->id)->get()[0];
        $CategoryQuery = CategoryQuery::where('id', $Category->id)->get()[0];

        $this->assertEquals($CategoryCommand->id, $CategoryQuery->id);
        $this->assertEquals($CategoryCommand->name, $CategoryQuery->name);
    }

    public function test_show_category(): void
    {
        $Category = CategoryQuery::latest()->first();
        $response = $this->get(route('category.show', ['category' => $Category->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $Category->id,
                'name' => $Category->name
            ],
        ]);
    }

    public function test_delete_category(): void
    {
        $Category = CategoryQuery::latest()->first();
        $response = $this->post(route('category.delete', ['category' => $Category->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure();
        $response->assertJson([
            "Message" => "Category Telah di Hapus"
        ]);
        $this->assertDatabaseHas('category_commands', ['id' => $Category->id], 'mysql_command');
        $this->assertDatabaseHas('category_queries', ['id' => $Category->id], 'mysql');
    }
}
