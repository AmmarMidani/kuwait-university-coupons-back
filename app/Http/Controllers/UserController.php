<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $users = User::query();

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $users->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%'])
                    ->orWhereRaw("LOWER(email) LIKE ?", ['%' . $searchValue . '%']);
            }

            $recordsFiltered = $users->count();
            if ($request->length != -1) {
                $users = $users->skip($request->start)->take($request->length)->get();
            } else {
                $users = $users->get();
            }

            $data = [];
            foreach ($users as $key => $value) {
                $data[] = [
                    'edit_url' => route('user.edit', $value->id),
                    'show_url' => route('user.show', $value->id),
                    'id' => $value->id,
                    'name' => $value->name,
                    'email' => $value->email,
                    'roles' => $value->roles->pluck('name'),
                    'status' => ($value->is_active) ? 'Active' : 'Inactive',
                    'status_text' => ($value->is_active) ? 'Active' : 'Inactive',
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
                'recordsTotal' => User::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all()->mapWithKeys(function ($item) {
            return [$item->name => $item->name];
        });

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User($request->all());
            $user->email_verified_at = now();
            $user->password = Hash::make($request->password);
            $user->save();

            // assign new roles
            if ($request->roles) {
                $user->syncRoles($request->roles);
            }
            return redirect(route('user.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all()->mapWithKeys(function ($item) {
            return [$item->name => $item->name];
        });
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            if (!$request->password) {
                $request->request->remove('password');
            } else {
                $request->merge([
                    'password' => Hash::make($request->password),
                ]);
            }
            // assign new roles
            $user->syncRoles($request->roles);
            $user->update($request->all());
            return redirect(route('user.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
