<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class BaseTaskRequest extends FormRequest
{
    public function mappedAttributes()
    {
        $attributesMap = [
            'title' => 'title',
            'description' => 'description',
            'assignedTo' => 'assigned_to',
            'priority' => 'priority',
            'status' => 'status',
            'isPinned' => 'is_pinned',
            'deliveryDate' => 'delivery_date',
            'assignedAt' => 'assigned_at',
            'createdAt' => 'created_at',
            'updatedAt' => 'udpated_at',
        ];

        $attributeToUpdate = [];

        foreach ($attributesMap as $key => $attributes) {
            if ($this->has($key)) {
                $attributeToUpdate[$attributes] = $this->input($key);
            }
        }

        return $attributeToUpdate;
    }
}
