<?php

namespace Mayrajp\Forms\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mayrajp\Forms\Http\Requests\CompletedFormRequest;
use Mayrajp\Forms\Http\Resources\CompletedFormResource;
use Mayrajp\Forms\Models\CompletedForm;
use Mayrajp\Forms\Services\CompletedFormService;
use Carbon\Carbon;
use Exception;

class CompletedFormController extends Controller
{
    private CompletedFormService $formService;

    public function __construct()
    {
        $this->formService = new CompletedFormService();
    }

    public function index()
    {
        $forms = CompletedForm::with('answers')->get();

        return CompletedFormResource::collection($forms);
    }

    public function show(int $id)
    {
        $form = CompletedForm::findOrFail($id);

        return new CompletedFormResource($form);
    }

    public function store(CompletedFormRequest $request)
    {
        try {

            $data = $request->validated();

            $this->formService->create($data);

            return response()->json([
                'message' => 'Answers added successfully',
            ], 200);
        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function update(CompletedFormRequest $request, int $id)
    {
        try {

            $data = $request->validated();

            $completedForm = CompletedForm::findOrFail($id);

            $nowDate = Carbon::now();

            $result = $nowDate->gt($completedForm->expires_in);

            if ($result) {
                return response()->json([
                    'message' => 'The date to change this form has expired',
                ], 403);
            }

            $this->formService->update($data);

            return response()->json([
                'message' => 'Answers updated successfully',
            ], 200);
        } catch (Exception $exception) {

            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
