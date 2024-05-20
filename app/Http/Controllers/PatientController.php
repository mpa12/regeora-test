<?php

namespace App\Http\Controllers;

use App\Http\Actions\PatientIndexAction;
use App\Http\Actions\PatientStoreAction;
use App\Http\Requests\PatientStoreRequest;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PatientIndexAction $action)
    {
        return $action();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreAction $action, PatientStoreRequest $request)
    {
        return $action($request);
    }
}
