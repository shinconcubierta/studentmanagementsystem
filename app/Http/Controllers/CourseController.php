<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('course_code', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%");
        }

        $courses = $query->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['enrollments.student']);
        return view('courses.show', compact('course'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses',
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'required|integer|min:1',
            'fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'required|integer|min:1',
            'fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}