<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Customers;
use App\Interfaces\CustomerInterface;
use App\Repositories\CustomerRepository;

use App\Models\ToDo;
use App\Interfaces\ToDoInterface;
use App\Repositories\ToDoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CustomerInterface::class, function (){
            return new CustomerRepository(new Customers());
        });
        $this->app->singleton(ToDoInterface::class, function(){
            return new ToDoRepository(new ToDo());
        });
    }

    public function provides()
    {
        return [
            CustomerInterface::class,
            ToDoInterface::class,
        ];
    }
}