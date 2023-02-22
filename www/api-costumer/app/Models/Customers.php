<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuid;

class Customers extends Authenticatable
{
    use HasFactory, HasApiTokens, HasFactory, Notifiable, Uuid;
    
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'name',
        'password',
        'email',
        'gender',
        'address',
        'is_married',
        'active',
    ];

    protected $hidden = [
        'id',
        'password',
    ];

    public function textGender()
    {
        switch (strtolower($this->gender)) {
            case 'l':
                return 'Man';
                break;
            case 'p':
                return "Woman";
                break;
            default:
                return "-";
                break;
        }
    }
}
