@extends('layouts.app')

@section('title', 'Students - Student TPS')
@section('header', 'Students')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" action="{{ route('students.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Search students..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('students.index') }}" class="btn btn-outline-danger ms-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            <i class=></i>Add Student
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                       <tr>
                        <th class="text-center">Student ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Enrollments</th>
                        <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <strong>{{ $student->student_id }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $student->full_name }}</strong><br>
                                        <span style="font-size: 0.85rem; color: #6c757d;">{{ $student->phone }}</span>
                                    </div>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $student->courses_count }} courses
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('students.show', $student) }}" 
                                           class="btn btn-outline-info" title="View">
                                            <i class=>Show</i>
                                        </a>
                                        <a href="{{ route('students.edit', $student) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class=>Edit</i>
                                        </a>
                                        <form method="POST" action="{{ route('students.destroy', $student) }}" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this student?')">
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
                {{ $students->links('components.pagination') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No students found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No students match your search criteria.
                    @else
                        Start by adding your first student.
                    @endif
                </p>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class=></i>Add Student
                </a>
            </div>
        @endif
    </div>
</div>
@endsection