<?php

namespace App\Http\Requests\Tasks;

class DeleteTaskRequest extends BaseTaskRequest
{
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:tasks,id']
        ];
    }
}
