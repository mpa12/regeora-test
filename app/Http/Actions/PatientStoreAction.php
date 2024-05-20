<?php

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class PatientStoreAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PatientStoreRequest $request): PatientResource
    {
        $patient = new Patient($request->validated());

        // Кэширование модели
        $patient->cache();

        return new PatientResource($patient);
    }
}
