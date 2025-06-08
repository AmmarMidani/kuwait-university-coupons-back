<?php

namespace App\Http\Controllers;

use App\Enums\GenderType;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Nationality;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recordsFiltered = 0;
            $students = Student::query();

            // search filter
            $searchValue = trim(strtolower(data_get($request, 'search.value', '')));
            if ($searchValue) {
                $students->whereRaw("LOWER(name) LIKE ?", ['%' . $searchValue . '%'])
                    ->orWhereRaw("LOWER(student_number) LIKE ?", ['%' . $searchValue . '%']);
            }

            $recordsFiltered = $students->count();
            if ($request->length != -1) {
                $students = $students->skip($request->start)->take($request->length)->get();
            } else {
                $students = $students->get();
            }

            $data = [];
            foreach ($students as $key => $value) {
                $data[] = [
                    'edit_url' => route('student.edit', $value->id),
                    'show_url' => route('student.show', $value->id),
                    'id' => $value->id,
                    'name' => $value->name,
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
                'recordsTotal' => Student::count(),
                'recordsFiltered' => $recordsFiltered,
                'data' => array_values($data->toArray()),
            ];
        }
        return view('students.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nationalities = Nationality::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $nationalities->prepend('- Select Nationality -', null);

        $programs = Program::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $programs->prepend('- Select Program -', null);

        $genders = collect(GenderType::asSelectArray());
        $genders->prepend('- Select Gender -', null);

        return view('students.create', compact('nationalities', 'programs', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $student = new Student($request->all());
            $student->password = Hash::make($request->password);
            $student->qr_code = (string) Str::uuid();
            $student->save();
            return redirect(route('student.index'))->with('success', trans('pages.public.added_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->gender_text = GenderType::fromValue($student->gender)->description;
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $nationalities = Nationality::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $nationalities->prepend('- Select Nationality -', null);

        $programs = Program::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $programs->prepend('- Select Program -', null);

        $genders = collect(GenderType::asSelectArray());
        $genders->prepend('- Select Gender -', null);
        return view('students.edit', compact('student', 'nationalities', 'programs', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        try {
            if (!$request->password) {
                $request->request->remove('password');
            } else {
                $request->merge([
                    'password' => Hash::make($request->password),
                ]);
            }
            $student->update($request->all());
            return redirect(route('student.index'))->with('success', trans('pages.public.updated_successfully'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
