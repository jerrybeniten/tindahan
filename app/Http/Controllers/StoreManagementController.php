<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
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

    public function getStores(Request $request): JsonResponse
    {
        $query = Store::query();

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
