<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Models\Store;
use App\Models\StoreLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreLocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        // Retrieve the store using the UUID from the request
        $uuid = $this->getStoreId($request->store_uuid);
        $store = Store::where('uuid', $uuid->uuid)->first();

        if (!$store) {
            return redirect()->back()->withErrors(['store_uuid' => 'Store not found']);
        }

        // Merge the store_id into the request data
        $data = $request->all();
        $data['store_id'] = $store->id;

        // Remove store_uuid to avoid mass assignment issues if it's not in the model's fillable
        unset($data['store_uuid']);

        StoreLocation::create($data);

        return Inertia::render('StoreManagement/Index');
    }

    public function getStoreLocations(Request $request): JsonResponse
    {
        // Retrieve the store UUID
        $uuid = $this->getStoreId($request->store_uuid);
        if (!$uuid) {
            return response()->json(['error' => 'Invalid store UUID'], 400);
        }

        // Initialize the query
        $query = StoreLocation::with('store')->where('store_id', $uuid->id);

        // Apply search conditions
        if ($search = $request->input('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('location_name', 'like', "%$search%")
                    ->orWhere('store_code', 'like', "%$search%")
                    ->orWhere('manager_name', 'like', "%$search%");
            });
        }

        // Apply sorting conditions
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_order'));
        }

        // Return paginated results
        $stores = $query->paginate(10);
        return response()->json($stores);
    }

    private function getStoreId($uuid)
    {
        return Store::where('uuid', $uuid)->first();
    }
}
