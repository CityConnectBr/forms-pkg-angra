<?php

namespace Mayrajp\Forms\Services;

use Mayrajp\Forms\Models\Answare;
use Mayrajp\Forms\Models\CompletedForm;
use Mayrajp\Forms\Models\DynamicForm;
use Mayrajp\Forms\Models\Field;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CompletedFormService
{
    public function create(array $data): void
    {
        try {

            $dynamicForm = DynamicForm::findOrFail($data['dynamic_form_id']);

            $time = strtotime($data['expires_in']);

            $completedForm = $dynamicForm->completedForms()->create([
                'user_id' => $data['user_id'],
                'expires_in' => date('Y-m-d', $time),
            ]);

            foreach ($data['answers'] as $dataAnsware) {

                $field = Field::find($dataAnsware['field_id']);

                if ($field->type == 'file') {
                    $this->saveTypeFile($completedForm, $dataAnsware);

                    continue;
                }

                $completedForm->answers()->create([
                    'field_id' => $dataAnsware['field_id'],
                    'answare' => json_encode($dataAnsware['answare']),
                ]);
            }
        } catch (Exception $exception) {

            $completedForm->answers()->delete();
            $completedForm->delete();

            throw new HttpException(500, $exception->getMessage());
        }
    }

    public function update(array $data): void
    {
        foreach ($data['answers'] as $dataAnsware) {

            $oldAnswer = Answare::find($dataAnsware['id']);

            $field = Field::find($dataAnsware['field_id']);

            if ($field->type == 'file') {

                $this->updateTypeFile($oldAnswer, $dataAnsware);

                continue;
            }

            $oldAnswer->answare = json_encode($dataAnsware['answare']);

            $oldAnswer->save();
        }
    }

    private function saveTypeFile(CompletedForm $completedForm, array $dataAnsware): void
    {

        $fileName = $this->createFileIntoStorage($dataAnsware);

        $completedForm->answers()->create([
            'field_id' => $dataAnsware['field_id'],
            'answare' => json_encode($fileName),
        ]);
    }

    private function updateTypeFile(Answare $oldAnsware, array $newAnsware): void
    {

        $file =  Storage::disk('public')->exists(json_decode($oldAnsware->answare));

        if ($file) {
            Storage::disk('public')->delete(json_decode($oldAnsware->answare));
        }

        $nameFile = $this->createFileIntoStorage($newAnsware);

        $oldAnsware->answare = json_encode($nameFile);

        $oldAnsware->save();
    }

    private function createFileIntoStorage(array $dataAnsware): string
    {
        $fileBase64 = $dataAnsware['answare'][0];

        $extension = explode('/', explode(':', substr($fileBase64, 0, strpos($fileBase64, ';')))[1])[1];

        $replace = substr($fileBase64, 0, strpos($fileBase64, ',') + 1);

        $file = str_replace($replace, '', $fileBase64);

        $file = str_replace(' ', '+', $file);

        $fileName = uniqid() . '.' . $extension;

        Storage::disk('public')->put($fileName, base64_decode($file));

        return $fileName;
    }
}
