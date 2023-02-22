<?php 
namespace App\Interfaces;

use App\Interfaces\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface ToDoInterface extends BaseRepository
{
    public function getAllTask(string $id, int $limit = 20): Collection;
    public function getTaskById(int $id): Model;
}