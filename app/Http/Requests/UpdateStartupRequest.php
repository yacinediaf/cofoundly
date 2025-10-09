<?php

namespace App\Http\Requests;

use App\Enums\StartupStage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStartupRequest extends FormRequest
{
    public function mappedAttributes(): array
    {
        $attributesMap = [
            'name' => 'name',
            'description' => 'description',
            'website' => 'website',
            'location' => 'location',
            'stage' => 'stage',
            'logo' => 'logo',
            'banner' => 'banner',
            'industry' => 'industry_id',
        ];

        $attributesToUpdate = [];

        foreach ($attributesMap as $inputKey => $attributeKey) {
            if (($this->has($inputKey))) {
                //in case of a file
                if ($this->file($inputKey)) {
                    $this->route('startup')->{'update' . ucfirst($inputKey)}($this->file($inputKey));
                    continue;
                }
                //in case of an empty input
                if ($this->input($inputKey) === null) {
                    continue;
                }
                $attributesToUpdate[$attributeKey] = $this->input($inputKey);
            }
        }

        return $attributesToUpdate;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'website' => 'sometimes|max:255',
            'location' => [
                'sometimes',
                'in:' . Rule::in(
                    collect(config('wilayas'))
                    ->pluck('id')
                    ->toArray()
                )
            ],
            'stage' => [
                'sometimes',
                Rule::enum(StartupStage::class)
            ],
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'industry' => 'sometimes|exists:industries,id',
        ];
    }
}
