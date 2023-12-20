<?php
namespace App\Http\Requests\Dashboard\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class SosRequestValidation extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules(){
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'number' => 'nullable|numeric',
        ];
        return $rules;
    }
}