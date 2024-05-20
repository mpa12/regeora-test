<?php

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class PatientIndexAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $patientKeys = Cache::get(Patient::CACHE_ALL_KEY, []);

        $patients = [];
        foreach ($patientKeys as $key) {
            $patient = Cache::get($key);
            if ($patient) {
                $patients[] = $patient;
            }
        }

        return PatientResource::collection($patients);
    }
}
