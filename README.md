# Package Dynamic Form

## Info

This package aims to provide APIs for developing dynamic forms.

### Run the package

`composer require natan/dynamic-forms`

### Run the migrations 

`php artisan migrate --path=/vendor/natan/dynamic-forms/database/migrations`

### You will need do add this routes to yout api.php :

```diff
use Mayrajp\Forms\Http\Controllers\Api\CompletedFormController;
use Mayrajp\Forms\Http\Controllers\Api\DynamicFormController;
use Mayrajp\Forms\Http\Controllers\Api\FieldController;

Route::apiResource('dynamic_forms', DynamicFormController::class);

Route::apiResource('field', FieldController::class);
Route::prefix('field')->controller(FieldController::class)->group(function () {
    Route::get('/all/by/form/{id}', 'getAllByForm');
});

Route::apiResource('completed_forms', CompletedFormController::class);
```








