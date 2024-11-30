<?php

namespace App\Http\Requests\Tasks;

class ReplaceTaskRequest extends BaseTaskRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255', 'sometimes'],
            'description' => ['sometimes'],
            'assignedTo' => ['sometimes', 'exists:users,id'],
            'deliveryDate' => ['sometimes', 'date_format:Y-m-d']
        ];
    }
}
