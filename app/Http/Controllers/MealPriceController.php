<?php

namespace App\Http\Controllers;

use App\Models\MealPrice;
use App\Http\Requests\StoreMealPriceRequest;
use App\Http\Requests\UpdateMealPriceRequest;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;

class MealPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $meal_prices = MealPrice::query();

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $meal_prices->whereRaw("LOWER(price) LIKE ?", ['%' . $searchValue . '%'])
                    ->orWhereHas("meal", function ($query) use ($searchValue) {
                        return $query->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%']);
                    })
                    ->orWhereHas("user", function ($query) use ($searchValue) {
                        return $query->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%']);
                    });
            }

            $recordsFiltered = $meal_prices->count();
            if ($request->length != -1) {
                $meal_prices = $meal_prices->skip($request->start)->take($request->length)->get();
            } else {
                $meal_prices = $meal_prices->get();
            }

            $data = [];
            foreach ($meal_prices as $key => $value) {
                $data[] = [
                    'edit_url' => route('meal-price.edit', $value->id),
                    'show_url' => route('meal-price.show', $value->id),
                    'id' => $value->id,
                    'meal_show_url' => route('meal.show', $value->meal->id),
                    'user_show_url' => route('user.show', $value->user->id),
                    'meal_name' => $value->meal->name,
                    'user_name' => $value->user->name,
                    'price' => $value->price,
                    'effective_date' => $value->effective_date,
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
                'recordsTotal' => MealPrice::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('meal_prices.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::merchants()->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $users->prepend('- Select User -', null);

        $meals = Meal::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $meals->prepend('- Select Meal -', null);

        return view('meal_prices.create', compact('users', 'meals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealPriceRequest $request)
    {
        try {
            $meal_price = new MealPrice($request->all());
            $meal_price->save();
            return redirect(route('meal-price.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MealPrice $meal_price)
    {
        return view('meal_prices.show', compact('meal_price'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MealPrice $meal_price)
    {
        $users = User::merchants()->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $users->prepend('- Select User -', null);

        $meals = Meal::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $meals->prepend('- Select Meal -', null);

        return view('meal_prices.edit', compact('meal_price', 'users', 'meals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealPriceRequest $request, MealPrice $meal_price)
    {
        try {
            $meal_price->update($request->all());
            return redirect(route('meal-price.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MealPrice $meal_price)
    {
        //
    }
}
