<?php
namespace App\Classes;


use App\Http\Resources\BookResource;
use App\Models\Books;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookManagement{
    private $bookRepository;

    public function __construct
    (
        BookRepositoryInterface $bookRepository
    ){
        $this->bookRepository = $bookRepository;
    }

    public function index(){
        $books = null;
        DB::transaction(function () use (&$books){
            $books = $this->bookRepository->index();
            $books = new BookResource($books);
        });
        return $books;
    }

    public function show($id){
        $book = null;
        DB::transaction(function () use(&$book, $id) {
            $book = $this->bookRepository->getById($id);
            $book = new BookResource($book);
        });
        return $book;
    }

    public function create(array $data){
        $book = null;
        DB::transaction(function () use(&$book, $data) {
            $book = $this->bookRepository->create($data);
            $book = new BookResource($book);
        });

        return $book;
    }

    public function edit(array $data, $id){
        $book = null;
        DB::transaction(function () use(&$book, $data, $id) {
            $book = $this->bookRepository->edit($data, $id);
            $book = new BookResource($book);
        });
        return $book;
    }


    public function delete($id){
        DB::transaction(function () use(&$id) {
            $this->bookRepository->delete($id);
        });
        return $this->bookRepository->index();
    }
}

