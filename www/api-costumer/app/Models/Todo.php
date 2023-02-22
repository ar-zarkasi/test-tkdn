<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user',
        'task',
    ];

    public function have_customer()
    {
        return $this->belongsTo(Customers::class,'id_user','id');
    }
}
