<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $meals = Meal::query();

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $meals->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%']);
            }

            $recordsFiltered = $meals->count();
            if ($request->length != -1) {
                $meals = $meals->skip($request->start)->take($request->length)->get();
            } else {
                $meals = $meals->get();
            }

            $data = [];
            foreach ($meals as $key => $value) {
                $data[] = [
                    'edit_url' => route('meal.edit', $value->id),
                    'show_url' => route('meal.show', $value->id),
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
                'recordsTotal' => Meal::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('meals.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealRequest $request)
    {
        try {
            $meal = new Meal($request->all());
            $meal->save();
            return redirect(route('meal.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        return view('meals.show', compact('meal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        return view('meals.edit', compact('meal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        try {
            $meal->update($request->all());
            return redirect(route('meal.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
