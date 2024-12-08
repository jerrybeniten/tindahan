<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Models\StoreLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreLocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        StoreLocation::create($request->all());

        return Inertia::render('StoreManagement/Index');
    }

    public function getStoreLocations(Request $request): JsonResponse
    {
        $query = StoreLocation::query();        

        // Apply search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        // Apply sorting
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->get('sort_by'), $request->get('sort_order'));
        }

        // Return paginated results
        $stores = $query->paginate(10);
        return response()->json($stores);
    }
}
