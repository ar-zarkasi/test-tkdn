<?php 
namespace App\Interfaces;

use App\Interfaces\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface CustomerInterface extends BaseRepository
{
    public function getAllUsers($limit = 20): Collection;
    public function getUserById(int $id): Model;
    public function getUserByUuid(string $uid): Model;
    public function getUserByEmail(string $id): Model;
    public function getFilteredUsers($params): Collection;
}