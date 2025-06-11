<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRoleRequest;
use App\Http\Requests\UpdateAdminRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    private $roles_to_block = ['admin', 'merchant'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $roles = Role::withCount('users');

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $roles->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%']);
            }

            $recordsFiltered = $roles->count();
            if ($request->length != -1) {
                $roles = $roles->skip($request->start)->take($request->length)->get();
            } else {
                $roles = $roles->get();
            }

            $data = [];
            foreach ($roles as $key => $value) {
                $data[] = [
                    'edit_url' => route('role.edit', $value->id),
                    'show_url' => route('role.show', $value->id),
                    'id' => $value->id,
                    'name' => $value->name,
                    'description' => $value->description ?? '',
                    'user_count' => $value->users_count,
                    'editable' => in_array($value->name, $this->roles_to_block) ? false : true,
                    'created_at' => $value->created_at->diffForHumans(),
                ];
            }

            // order rows
            $order_by = $request->columns[$request->order[0]['column']]['name'];
            $order_dir = $request->order[0]['dir'];

            $data = collect($data)->sortBy($order_by);
            if ($order_dir == 'desc') {
                $data = $data->reverse();
            }

            return [
                'draw' => $request->draw,
                'recordsTotal' => Role::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('roles.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRoleRequest $request)
    {
        try {
            $role = Role::create([
                'name' => trim($request->name),
            ]);
            $role->syncPermissions($request->permissions);
            return redirect(route('role.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::all()->groupBy('group_name');
        $selected_roles = $role->permissions->pluck('name');
        return view('roles.show', compact('role', 'permissions', 'selected_roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (in_array($role->name, $this->roles_to_block)) {
            return redirect()->back()->with('error', 'This role is protected you cannot edit it');
        }
        $permissions = Permission::all()->groupBy('group_name');
        $selected_roles = $role->permissions->pluck('name');
        return view('roles.edit', compact('role', 'permissions', 'selected_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRoleRequest $request, Role $role)
    {
        if (in_array($role->name, $this->roles_to_block)) {
            return redirect()->back()->with('error', 'This role is protected you cannot delete it');
        }
        try {
            $role->name = trim($request->name);
            $role->description = trim($request->description);
            $role->save();
            $role->syncPermissions($request->permissions);
            return redirect(route('role.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, $this->roles_to_block)) {
            return redirect()->back()->with('error', 'This role is protected you cannot delete it');
        }
        try {
            $users = User::all();
            foreach ($users as $value) {
                $value->removeRole($role->name);
            }
            $role->delete();
            return redirect(route('role.index'))->with('success', trans('pages.public.deleted_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
