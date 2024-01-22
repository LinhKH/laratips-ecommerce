<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionsRequest;
use App\Http\Resources\PermissionResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    private string $routeResourceName = 'permissions';
    public function index(Request $request)
    {
        $permissions = Permission::query()
            ->select(['id', 'name', 'created_at'])
            ->when($request->name, fn (Builder $builder, $name) => $builder->where('name', 'like', "%{$name}%"))
            ->latest('id')
            ->paginate();
        return Inertia::render('Permission/Index', [
            'title' => 'Permissions List',
            'items' => PermissionResource::collection($permissions),
            'headers' => [
                [
                    'label' => 'Name',
                    'name' => 'name'
                ],
                [
                    'label' => 'Created At',
                    'name' => 'created_at'
                ],
                [
                    'label' => 'Actions',
                    'name' => 'actions'
                ]
                ],
                'filters' => (object) $request->all(),
                'routeResourceName' => $this->routeResourceName
        ]);
    }

    public function create()
    {
        return Inertia::render('Permission/Create', [
            'edit' => false,
            'title' => 'Create Permission',
            'routeResourceName' => $this->routeResourceName
        ]);
    }

    public function store(PermissionsRequest $request)
    {
        $permission = Permission::create($request->validated());

        return redirect()->route("admin.permissions.index")->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {

        return Inertia::render('Permission/Create', [
            'edit' => true,
            'title' => 'Edit Permission',
            'item' => new PermissionResource($permission),
            'routeResourceName' => $this->routeResourceName
        ]);
    }

    public function update(PermissionsRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return redirect()->route("admin.permissions.index")->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission deleted successfully.');
    }
}
