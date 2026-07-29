<?php

namespace App\Http\Requests\DigitalLibrary;

use Illuminate\Foundation\Http\FormRequest;

class ImportBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120', 
        ];
    }

    public function messages(): array
    {
        return [
            'file_excel.required' => 'File Excel wajib diunggah!',
            'file_excel.mimes'    => 'Format file harus berupa .xlsx, .xls, atau .csv!',
            'file_excel.max'      => 'Ukuran file tidak boleh lebih dari 5MB!',
        ];
    }
}