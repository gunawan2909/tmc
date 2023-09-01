<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ProductQuery;
use App\Models\CategoryQuery;
use App\Models\ProductCommand;
use App\Models\CategoryCommand;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }


    public function test_store_product(): void
    {

        $category = CategoryCommand::create(['name' => "Test-Category"]);
        CategoryQuery::create(['name' => "Test-Category", "id" => $category->id]);
        $str = Str::random(40);
        $data = [
            'name' => "Test-Product",
            "sku" => $str,
            "price" => 100000,
            "stock" => 50,
            "category_id" => $category->id,

        ];
        $response = $this->post(route('product.add'), $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'name',
                "sku",
                "price",
                "stock",
                "category" => [
                    "id",
                    "name"
                ],
            ],
        ]);
        $response->assertJson([
            'data' => [
                'name' => "Test-Product",
                "sku" => $str,
                "price" => 100000,
                "stock" => 50,
                "category" => [
                    "id" => $category->id,
                    "name" => $category->name

                ]
            ],
        ]);
        $this->assertDatabaseHas('product_queries', [
            'name' => "Test-Product",
            "sku" => $str,
            "price" => 100000,
            "stock" => 50,
            "category_id" => $category->id
        ]);
        $ProductCommand = ProductCommand::latest()->first();
        $ProductQuery = ProductQuery::latest()->first();

        $this->assertEquals($ProductCommand->id, $ProductQuery->id);
        $this->assertEquals($ProductCommand->name, $ProductQuery->name);
    }



    public function test_index_product(): void
    {

        $response = $this->get(route('product.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'data' => [
                        'id',
                        'name',
                        'sku',
                        'category' => [
                            'name',
                            'id'
                        ],
                        'price',
                        'stock'
                    ]
                ]
            ],
        ]);
    }

    public function test_update_product(): void
    {


        $product = ProductQuery::latest()->first();
        $str = Str::random(40);
        $data = [
            'name' => "Test-Product-Update",
            "sku" => $str,
            "price" => 100000,
            "stock" => 50,
            "category_id" => $product->category->id,
        ];
        $response = $this->post(route('product.update', ['product' => $product->id]), $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'name',
                "sku",
                "price",
                "stock",
                "category" => [
                    "id",
                    "name"
                ],
            ],
        ]);
        $response->assertJson([
            'data' => [
                'name' => "Test-Product-Update",
                "sku" => $str,
                "price" => 100000,
                "stock" => 50,
                "category" => [
                    "id" => $product->category->id,
                    "name" => $product->category->name

                ]
            ],
        ]);
        $this->assertDatabaseHas('product_queries', [
            'name' => "Test-Product-Update",
            "sku" => $str,
            "price" => 100000,
            "stock" => 50,
            "category_id" => $product->category->id,
        ]);
        $ProductCommand = ProductCommand::where('id', $product->id)->get()[0];
        $ProductQuery = ProductQuery::where('id', $product->id)->get()[0];
        $this->assertEquals($ProductCommand->id, $ProductQuery->id);
        $this->assertEquals($ProductCommand->name, $ProductQuery->name);
    }
    public function test_show_product(): void
    {
        $Product = ProductQuery::latest()->first();
        $response = $this->get(route('product.show', ['product' => $Product->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $Product->id,
                'name' => $Product->name
            ],
        ]);
    }
    public function test_delete_product(): void
    {
        $Product = ProductQuery::latest()->first();
        $response = $this->post(route('product.delete', ['product' => $Product->id]));
        $response->assertStatus(200);
        $response->assertJsonStructure();
        $response->assertJson([
            "Message" => "Product Telah di Hapus"
        ]);
        $this->assertDatabaseHas('product_commands', ['id' => $Product->id], 'mysql_command');
        $this->assertDatabaseHas('product_queries', ['id' => $Product->id], 'mysql');
    }
}
