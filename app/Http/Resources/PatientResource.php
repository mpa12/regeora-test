<?php

namespace App\Http\Resources;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Patient resource
 *
 * @OA\Schema(
 *     schema="PatientResource",
 *     type="object",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="birthdate", type="string", format="date"),
 *     @OA\Property(property="age", type="string")
 * )
 */
class PatientResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->getName(),
            'birthdate' => $this->resource->getBirthdateText(),
            'age' => $this->resource->getAgeText(),
        ];
    }
}
