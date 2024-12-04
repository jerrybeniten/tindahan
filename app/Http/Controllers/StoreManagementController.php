<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
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

    public function updateStore(UpdateStoreRequest $request): void
    {
        $uuid = $request->get('uuid');
        $name = $request->get('name');
        $description = $request->get('description');

        Store::where('uuid', $uuid)
            ->update([
                'name' => $name,
                'description' => $description
            ]);
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

        $query->orderBy('id', 'DESC');

        // Apply sorting
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->get('sort_by'), $request->get('sort_order'));
        }

        // Return paginated results
        $stores = $query->paginate(10);
        return response()->json($stores);
    }

    public function viewStore(Request $request): JsonResponse
    {
        $uuid = $request->get('uuid');
        $data = Store::where('uuid', $uuid)->first();
        return response()->json($data);
    }
}
