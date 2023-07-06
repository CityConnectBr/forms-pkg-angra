<?php

namespace Mayrajp\Forms\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mayrajp\Forms\Http\Requests\FieldRequest;
use Mayrajp\Forms\Http\Resources\FieldResource;
use Mayrajp\Forms\Models\DynamicForm;
use Mayrajp\Forms\Models\Field;
use Mayrajp\Forms\Services\FieldService;
use Exception;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    private FieldService $fieldService;

    public function __construct()
    {
        $this->fieldService = new FieldService();
    }

    public function getAllByForm(int $id)
    {
        $dynamicForm = DynamicForm::findOrFail($id);

        $fields = $dynamicForm->fields()->where('is_active', true)->get();

        return FieldResource::collection($fields);
    }

    public function create(FieldRequest $request)
    {
        try {

            $data = $request->validated();

            $dynamicForm = DynamicForm::findOrFail($data['form_id']);

            $this->fieldService->create($dynamicForm, $data);

            return response()->json([
                'message' => 'Field added successfully',
            ], 200);
        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function show(int $id)
    {
        $field = Field::findOrFail($id);

        return new FieldResource($field);
    }

    public function delete(int $id)
    {
        $field = Field::findOrFail($id);

        $field->is_active = false;

        $field->save();

        return response()->json([
            'message' => 'Field has been deactivated successfully',
        ]);
    }

    public function update(FieldRequest $request, int $id)
    {
        try {

            $data = $request->validated();

            $field = Field::findOrFail($id);

            $dynamicForm = DynamicForm::findOrFail($data['form_id']);

            $this->fieldService->update($field, $dynamicForm, $data);

            return response()->json([
                'message' => 'Field updated successfully',
            ], 200);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
