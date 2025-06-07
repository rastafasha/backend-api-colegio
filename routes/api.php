<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\CalificacionController;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\Doctor\DoctorController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangeForgotPasswordControllerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('register', [AuthController::class, 'register'])
//     ->name('register');

// Route::post('login', [AuthController::class, 'login'])
//     ->name('login');





Route::group(['middleware' => 'api'], function ($router) {

    // Auth
    require __DIR__ . '/api_routes/auth.php';

    // users
    require __DIR__ . '/api_routes/users.php';
    
    // roles
    require __DIR__ . '/api_routes/roles.php';
    
    
    // setting
    require __DIR__ . '/api_routes/setting.php';
    
   
    // sliders
    require __DIR__ . '/api_routes/sliders.php';

    
    // proveedor
    require __DIR__ . '/api_routes/proveedor.php';
    
    // payment
    require __DIR__ . '/api_routes/payment.php';
    
    // paymentMethod
    require __DIR__ . '/api_routes/paymentMethod.php';
    
    // parent
    require __DIR__ . '/api_routes/parent.php';
    
    // student
    require __DIR__ . '/api_routes/student.php';
    
    // tasabcv
    require __DIR__ . '/api_routes/tasabcv.php';
    // moroso
    require __DIR__ . '/api_routes/moroso.php';
    
    // admindashboard
    require __DIR__ . '/api_routes/admindashboard.php';
    
    // materias
    require __DIR__ . '/api_routes/materias.php';
    // calificaciones
    require __DIR__ . '/api_routes/calificaciones.php';
    
    // examen
    require __DIR__ . '/api_routes/examen.php';
    
    // category
    require __DIR__ . '/api_routes/category.php';
    
    // blog
    require __DIR__ . '/api_routes/blog.php';
    
    // calendariotarea
    require __DIR__ . '/api_routes/calendariotarea.php';
    




    //comandos desde la url del backend

    Route::get('/cache', function () {
        Artisan::call('cache:clear');
        return "Cache";
    });

    Route::get('/optimize', function () {
        Artisan::call('optimize:clear');
        return "Optimización de Laravel";
    });

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return "Storage Link";
    });


    Route::get('/migrate-seed', function () {
        Artisan::call('migrate:refresh --seed');
        return "Migrate seed";
    });
    
    Route::get('/send-notification', function () {
        Artisan::call('command:notification-appointments');
        return "Send All notifications";
    });
    
    Route::get('/send-whatsapp', function () {
        Artisan::call('command:notification-appointment-whatsapp');
        return "Send All whatsapp";
    });




    //rutas libres

    Route::post('/contact/form', [ContactFormController::class, 'contactStore'])
        ->name('contact.store');

    // Route::get('/categories', [CategoryController::class, 'index'])
    //     ->name('category.index');


});
