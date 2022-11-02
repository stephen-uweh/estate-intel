<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/api/v1/books');

        $response->assertStatus(200);
    }

    public function test_show()
    {   
        $id = 4;
        $response = $this->get('/api/v1/books/'.$id);

        $response->assertStatus(200);
    }

    public function test_create(){
        $payload = [
            "name" => "My Second Book",
            "isbn" => "123-3213243567",
            "authors" => [
                "John Doe"
            ],
            "number_of_pages" => 350,
            "publisher" => "Acme Books",
            "country" => "United States",
            "release_date" => "2019-08-01"
        ];

        $response = $this->post('/api/v1/books/', $payload);

        $response->assertStatus(201);
    }

    // public function test_edit(){
    //     $id = 8;
    //     $payload = [
    //         "name" => "My Fourth Book",
    //         "country" => "Germany",
    //     ]; 

    //     $response = $this->patch('/api/v1/books/'.$id, $payload);

    //     $response->assertStatus(200);
    // }

    // public function test_delete(){
    //     $id = 7;
    //     $response = $this->delete('/api/v1/books/'.$id);

    //     $response->assertStatus(204);
    // }


    public function test_external(){
        $name = "A Game of Thrones";

        $response = $this->get('/api/v1/external-books?name='.$name);

        $response->assertStatus(200);
    }
}
