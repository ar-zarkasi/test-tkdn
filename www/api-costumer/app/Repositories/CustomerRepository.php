<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\CustomerInterface;
use App\Repositories\EloquentRepository;

class CustomerRepository extends EloquentRepository implements CustomerInterface
{
    protected $with = [];

    public function getAllUsers($limit = 20) : Collection
    {
        return $this->model
            ->with($this->with)
            ->limit($limit)
            ->get();
    }

    public function getUserById(int $id): Model
    {
        return $this->model
            ->with($this->with)
            ->where('id', $id)
            ->where('active', 1)
            ->firstOrNew();
    }

    public function getUserByUuid(string $uid): Model
    {
        return $this->model
            ->with($this->with)
            ->where('uuid', $uid)
            ->where('active', 1)
            ->firstOrNew();
    }

    public function getUserByEmail(string $id): Model
    {
        return $this->model
            ->with($this->with)
            ->where('email', $id)
            ->firstOrNew();
    }

    public function getFilteredUsers($params): Collection
    {
        $el = $this->model
            ->with($this->with);
        
        foreach ($params as $key => $value) {
            $el->where($key, $value);
        }

        return $el->get();
    }
}