<?php
namespace CustomRouting\v1;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Request;

class AuthRoutes
{

    public function __construct()
    {
        $this->registerRoutes();
    }

    private function registerRoutes(){
        Route::prefix('costumers')->group(function(){
            Route::get('/',[CustomerController::class,'all'])->name('customers'); //done
            Route::post('/',[CustomerController::class,'store'])->name('customers.create'); // done
            Route::get('/{id}',[CustomerController::class,'detail'])->name('customers.detail');  // done
            Route::put('/{id}',[CustomerController::class,'update'])->name('customers.update'); // done
            Route::delete('/{id}',[CustomerController::class,'destroy'])->name('customers.delete'); // 
        });
    }
}
