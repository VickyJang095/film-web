<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_path' => 'nullable|mimes:mp4,mov,avi,wmv,flv,mpeg,mpg,m4v,webm,mkv|max:20480',
            'status' => 'required|in:active,inactive',
            'year' => 'required|integer',
            'duration' => 'required|integer',
            'genre' => 'nullable|string',
        ];
    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Validation errors', 'data' => $validator->errors()], 422));
    }
}
