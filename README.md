# Package Dynamic Form

## Info

This package aims to provide APIs for developing dynamic forms.

### Run the package

`composer require city/connect/dynamic/forms`

### Run the migrations 

`php artisan migrate --path=/vendor/city/connect/dynamic/forms/database/migrations`

### You will need do add this routes to yout api.php :

***Warning** : If you want to see the routes updated with the latest version of the package, access the folder /vendor/city/connect/dynamic/forms/routes

```sh

use Mayrajp\Forms\Http\Controllers\Api\CompletedFormController;
use Mayrajp\Forms\Http\Controllers\Api\DynamicFormController;
use Mayrajp\Forms\Http\Controllers\Api\FieldController;

Route::controller(DynamicFormController::class)->group(function () {
    Route::get('/dynamic_forms/all', 'index');
    Route::post('/dynamic_forms/create', 'create');
    Route::get('/dynamic_forms/show/{id}', 'show');
    Route::put('/dynamic_forms/update/{id}', 'update');
    Route::delete('/dynamic_forms/delete/{id}', 'destroy');
});

Route::controller(FieldController::class)->group(function () {
    Route::post('/field/create', 'create');
    Route::get('/field/all/by/form/{id}', 'getAllByForm');
    Route::get('/field/show/{id}', 'show');
    Route::put('/field/update/{id}', 'update');
    Route::delete('/field/delete/{id}', 'delete');
});

Route::controller(CompletedFormController::class)->group(function () {
    Route::get('/completed_forms/all', 'index');
    Route::get('/completed_forms/show/{id}', 'show');
    Route::post('/completed_forms/create', 'create');
    Route::put('/completed_forms/update/{id}', 'update');   
});
```








