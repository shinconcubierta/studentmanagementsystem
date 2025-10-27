@extends('layouts.app')

@section('title', 'Courses - Student TPS')
@section('header', 'Courses')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" action="{{ route('courses.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Search courses..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('courses.index') }}" class="btn btn-outline-danger ms-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('courses.create') }}" class="btn btn-primary">
            <i class=></i>Add Course
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($courses->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Course Code</th>
                            <th class="text-center">Course Name</th>
                            <th class="text-center">Units</th>
                            <th class="text-center">Fee</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Students</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $course->course_code }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $course->course_name }}</strong>
                                        @if($course->description)
                                            <br><small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $course->units }} units</span>
                                </td>
                                <td>
                                    <strong class="text-success">₱{{ number_format($course->fee, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $course->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $course->enrolled_students_count ?? 0 }} enrolled
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('courses.show', $course) }}" 
                                           class="btn btn-outline-info" title="View">
                                            <i class=>Show</i>
                                        </a>
                                        <a href="{{ route('courses.edit', $course) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class=>Edit</i>
                                        </a>
                                        <form method="POST" action="{{ route('courses.destroy', $course) }}" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this course?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class=>Delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $courses->links('components.pagination') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No courses found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No courses match your search criteria.
                    @else
                        Start by adding your first course.
                    @endif
                </p>
                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                    <i class=></i>Add Course
                </a>
            </div>
        @endif
    </div>
</div>
@endsection