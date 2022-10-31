<?php
namespace App\Repositories\Interfaces;

use App\Models\Books;
use Illuminate\Database\Eloquent\Model;

interface BookRepositoryInterface {
    public function create(array $data): Model;

    public function index();

    public function getById(string $id): Books;

    public function edit(array $data, string $id): Books;

    public function delete(string $id);
}
