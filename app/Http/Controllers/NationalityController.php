<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use App\Http\Requests\StoreNationalityRequest;
use App\Http\Requests\UpdateNationalityRequest;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $nationalities = Nationality::query();

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $nationalities->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%']);
            }

            $recordsFiltered = $nationalities->count();
            if ($request->length != -1) {
                $nationalities = $nationalities->skip($request->start)->take($request->length)->get();
            } else {
                $nationalities = $nationalities->get();
            }

            $data = [];
            foreach ($nationalities as $key => $value) {
                $data[] = [
                    'edit_url' => route('nationality.edit', $value->id),
                    'show_url' => route('nationality.show', $value->id),
                    'id' => $value->id,
                    'name' => $value->name,
                    'time_from' => $value->time_from,
                    'time_to' => $value->time_to,
                    'status' => $value->is_active,
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
                'recordsTotal' => Nationality::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('nationalities.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nationalities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNationalityRequest $request)
    {
        try {
            $nationality = new Nationality($request->all());
            $nationality->save();
            return redirect(route('nationality.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Nationality $nationality)
    {
        return view('nationalities.show', compact('nationality'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nationality $nationality)
    {
        return view('nationalities.edit', compact('nationality'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNationalityRequest $request, Nationality $nationality)
    {
        try {
            $nationality->update($request->all());
            return redirect(route('nationality.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nationality $nationality)
    {
        //
    }
}
