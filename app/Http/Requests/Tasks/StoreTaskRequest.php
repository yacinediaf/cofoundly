<?php

namespace App\Http\Requests\Tasks;

class StoreTaskRequest extends BaseTaskRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255', 'required'],
            'description' => ['required'],
            'assignedTo' => ['required', 'exists:users,id'],
            'deliveryDate' => ['required', 'date_format:Y-m-d']
        ];
    }
}
