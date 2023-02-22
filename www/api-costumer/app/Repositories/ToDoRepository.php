<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\ToDoInterface;
use App\Repositories\EloquentRepository;

class ToDoRepository extends EloquentRepository implements ToDoInterface
{
    protected $with = ['have_customer'];
    public function getAllTask(string $id, int $limit = 20): Collection
    {
        return $this->model
            ->with($this->with)
            ->limit($limit)
            ->whereHas('have_customer', function ($query) use($id){
                $query->where('uuid',$id);
            })
            ->get();
    }
    public function getTaskById(int $id): Model
    {
        return $this->model
            ->with($this->with)
            ->where('id', $id)
            ->firstOrCreate();
    }
}