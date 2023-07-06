<?php

namespace Mayrajp\Forms\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mayrajp\Forms\Http\Requests\DynamicFormRequest;
use Mayrajp\Forms\Http\Resources\DynamicFormResource;
use Mayrajp\Forms\Models\DynamicForm;
use Mayrajp\Forms\Services\DynamicFormService;
use Exception;

class DynamicFormController extends Controller
{

    private DynamicFormService $dynamicFormService;

    public function __construct()
    {
        $this->dynamicFormService = new DynamicFormService();
    }

   
    public function index()
    {

        $forms = DynamicForm::with('fields')->get();

        return DynamicFormResource::collection($forms);
    }

   
    public function create(DynamicFormRequest $request)
    {
        try {
            $data = $request->validated();

            $return = $this->dynamicFormService->create($data);

            return new DynamicFormResource($return);
        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }

   
    public function show(int $id)
    {
        $dynamicForm = DynamicForm::findOrFail($id);

        return new DynamicFormResource($dynamicForm);
    }


    
    public function update(DynamicFormRequest $request, int $id)
    {
        try {

            $data = $request->validated();

            $dynamicForm = DynamicForm::findOrFail($id);

            $this->dynamicFormService->update($dynamicForm, $data);

            return new DynamicFormResource($dynamicForm);
        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    
    public function destroy(int $id)
    {
        try {

            $dynamicForm = DynamicForm::findOrFail($id);

            $this->dynamicFormService->destroy($dynamicForm);

            return response()->json(['message' => 'Successfully deleted'], 200);
            
        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
