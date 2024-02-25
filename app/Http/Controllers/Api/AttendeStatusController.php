<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeStatusResource;
use App\Models\AttendeStatus;
use Illuminate\Http\Request;

class AttendeStatusController extends Controller
{
    public function index()
    {
        return AttendeStatusResource::collection(AttendeStatus::all())
            ->additional([
                'status' => 'success',
                'message' => 'Attende Status List'
            ]);
    }
}
