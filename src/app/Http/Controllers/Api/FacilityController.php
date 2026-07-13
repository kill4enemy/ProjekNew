<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities.
     */
    public function index()
    {
        $facilities = Facility::all();
        return response()->json($facilities);
    }

    /**
     * Display the specified facility.
     */
    public function show(Facility $facility)
    {
        return response()->json($facility);
    }
}
