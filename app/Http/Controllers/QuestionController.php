<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $questions = Question::query();

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $questions->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%']);
            }

            $recordsFiltered = $questions->count();
            if ($request->length != -1) {
                $questions = $questions->skip($request->start)->take($request->length)->get();
            } else {
                $questions = $questions->get();
            }

            $data = [];
            foreach ($questions as $key => $value) {
                $data[] = [
                    'edit_url' => route('question.edit', $value->id),
                    'show_url' => route('question.show', $value->id),
                    'id' => $value->id,
                    'question_text' => $value->question_text,
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
                'recordsTotal' => Question::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('questions.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        try {
            $question = new Question($request->all());
            $question->options = json_encode([1, 2, 3, 4, 5]);
            $question->save();
            return redirect(route('question.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        try {
            $question->update($request->all());
            return redirect(route('question.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
