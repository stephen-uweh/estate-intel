<?php

namespace App\Http\Controllers;

use App\Classes\BookManagement;
use App\Exceptions\UnprocessableEntityException;
use App\Models\Books;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    private $book;

    public function __construct(BookManagement $book)
    {
        $this->book = $book;
    }
    
    public function index(){
        return response()->json([
            "status_code" => 200,
            "status" => "success",
            "data" => $this->book->index()
        ]);
    }

    public function show($id){
        return response()->json([
            "status_code" => 200,
            "status" => "success",
            "data" => $this->book->show($id)
        ]);
    }


    public function create(Request $request){
        $validator = Validator::make($request->all(), [
           "name" => "required",
           "isbn" => "required",
           "authors" => "required",
           "country" => "required",
           "number_of_pages" => "required",
           "publisher" => "required",
           "release_date" => "required",
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            return response()->json([
                'success' => false,
                'message' => $errors
            ], 500);
        }

        $data = $this->book->create($request->all());
        $res = [
            'book' => $data
        ];
        return response()->json([
            "status_code" => 201,
            "status" => "success",
            "data" => $res,
        ], 201);
        
    }

    public function edit(Request $request, $id){
        $data = $request->all();
        $book = $this->book->edit($request->all(), $id);
        
        return response()->json([
            "status_code" => 200,
            "status" => "success",
            "message" => 'The book '.$book['name'].' was deleted successfully',
            "data" => $book,
        ]);
    }

    public function delete($id){
        $book = $this->book->show($id);
        $this->book->delete($id);
        return response()->json([
            "status_code" => 204,
            "status" => "success",
            "message" => 'The book '.$book['name'].' was deleted successfully',
            "data" => []
        ], 204);
        
    }

    public function externalBook(Request $request){
        $name = $request->name;
        $url = "https://www.anapioficeandfire.com/api/books?name="."".$name;
        $req = Http::get($url);
        $res = json_decode($req->body());

        if ($res){
            $data = [
                'name' => $res[0]->name,
                'isbn' => $res[0]->isbn,
                'authors' => $res[0]->authors,
                'number_of_pages' => $res[0]->numberOfPages,
                'publisher' => $res[0]->publisher,
                'country' => $res[0]->country,
                'release_date' => Carbon::parse($res[0]->released)->format('Y-m-d')
            ];

            return response()->json([
                'status_code' => $req->status(),
                'status' => 'success',
                'data' => [$data]
            ], 200);
        }

        if(!$res){
            return response()->json([
                'status_code' => 404,
                'status' => 'not found',
                'data' => []
            ], 404);
        }
        
    }
}