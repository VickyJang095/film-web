<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMovieRequest extends FormRequest
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
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'duration' => 'required|integer|min:1|max:999',
            'type' => 'required|in:single,series',
            'country_id' => 'required|exists:countries,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'poster' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'episode_numbers' => 'array',
            'episode_numbers.*' => 'integer|min:1',
            'episode_titles' => 'array',
            'episode_titles.*' => 'nullable|string|max:255',
            'episode_files' => 'array',
            'episode_files.*' => 'nullable|file|mimes:mp4,webm|max:512000'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tên phim',
            'description.required' => 'Vui lòng nhập mô tả phim',
            'release_year.required' => 'Vui lòng nhập năm phát hành',
            'duration.required' => 'Vui lòng nhập thời lượng phim',
            'type.required' => 'Vui lòng chọn loại phim',
            'country_id.required' => 'Vui lòng chọn quốc gia',
            'categories.required' => 'Vui lòng chọn ít nhất một thể loại',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 422));
    }
}
