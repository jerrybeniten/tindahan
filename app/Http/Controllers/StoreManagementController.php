<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StoreManagementController extends Controller
{
    public function index(): Response
    {        
        return Inertia::render('StoreManagement/Index');
    }

    public function store(StoreStoreRequest $request)
    {                        
        Store::create($request->all());

        return Inertia::render('StoreManagement/Index');
    }
}
