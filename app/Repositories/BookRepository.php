<?php
namespace App\Repositories;

use App\Exceptions\UnprocessableEntityException;
use App\Models\Books;
use App\Traits\ExceptionsHandlers;
use App\Traits\updateModel;
use Illuminate\Database\Eloquent\Model;
use Dotenv\Exception\ValidationException;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookRepository extends BaseRepository implements BookRepositoryInterface{

    use ExceptionsHandlers, updateModel;

    public function __construct(Books $model)
    {
        parent::__construct($model);
    }

    public function index(){
        return $this->model->all();
    }

    public function getById(string $id): Books
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model {
        $book = null;
        DB::transaction(function () use ($data, &$book) {
            $book = $this->model->create([
                'name' => $data['name'],
                'isbn' => $data['isbn'],
                'authors' => $data['authors'],
                'number_of_pages' => $data['number_of_pages'],
                'publisher' => $data['publisher'],
                'country' => $data['country'],
                'release_date' => $data['release_date'],
            ]);
            $this->checkIfResourceFound($book, 'Unable to add book.');
        });
        return $book;
    }

    public function edit(array $data, string $id): Books
    {
        $book = null;
        DB::transaction(function () use ($data, $id, &$book) {
            $book = $this->model->findOrFail($id);
            $book->fill($data);
            if ($book->isClean()) {
                throw new UnprocessableEntityException("Book cannot be updated as details is the same");
            }
            $book->update($data);
        });
        return $book;
    }

    public function delete(string $id){
        $this->model->where('id', $id)->delete();
    }

}




