@extends('layouts.app')

@section('title', 'View Course - Student TPS')
@section('header', 'Course Details')

@section('content')
<div class="row">
    <!-- Course Information -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Course Information</h5>
                <span class="badge bg-{{ $course->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($course->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; font-size: 1.5rem;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4 class="mt-2 mb-0">{{ $course->course_name }}</h4>
                    <small class="text-muted">{{ $course->course_code }}</small>
                </div>
                
                <hr>
                
                @if($course->description)
                <div class="mb-3">
                    <strong><i class="fas fa-align-left me-2"></i>Description:</strong><br>
                    <p class="text-muted mb-0">{{ $course->description }}</p>
                </div>
                @endif
                
                <div class="mb-2">
                    <strong><i class="fas fa-graduation-cap me-2"></i>Units:</strong><br>
                    <span class="badge bg-info fs-6">{{ $course->units }} units</span>
                </div>
                
                <div class="mb-2">
                    <strong><i class="fas fa-peso-sign me-2"></i>Course Fee:</strong><br>
                    <h5 class="text-success mb-0">₱{{ number_format($course->fee, 2) }}</h5>
                </div>
                
                <div class="mb-2">
                    <strong><i class="fas fa-users me-2"></i>Enrolled Students:</strong><br>
                    <span class="badge bg-primary fs-6">{{ $course->enrollments->count() }} students</span>
                </div>
                
                <div class="mb-2">
                    <strong><i class="fas fa-clock me-2"></i>Created:</strong><br>
                    {{ $course->created_at->format('F j, Y g:i A') }}
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Course Statistics -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-primary">{{ $course->enrollments->where('status', 'enrolled')->count() }}</h4>
                        <small class="text-muted">Active</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success">{{ $course->enrollments->where('status', 'completed')->count() }}</h4>
                        <small class="text-muted">Completed</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-secondary">{{ $course->enrollments->where('status', 'dropped')->count() }}</h4>
                        <small class="text-muted">Dropped</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <h5 class="mb-0 text-success">
                        ₱{{ number_format($course->enrollments->count() * $course->fee, 2) }}
                    </h5>
                    <small class="text-muted">Total Revenue</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enrolled Students -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enrolled Students</h5>
                <a href="{{ route('enrollments.create') }}?course_id={{ $course->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Add Student
                </a>
            </div>
            <div class="card-body">
                @if($course->enrollments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Student</th>
                                    <th class="text-center">Student ID</th>
                                    <th class="text-center">Enrollment Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->enrollments->sortBy('student.last_name') as $enrollment)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $enrollment->student->full_name }}</strong><br>
                                                <small class="text-muted">{{ $enrollment->student->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ $enrollment->student->student_id }}</strong>
                                        </td>
                                        <td>{{ $enrollment->enrollment_date->format('M j, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'completed' ? 'primary' : 'secondary') }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($enrollment->grade)
                                                <span class="badge bg-{{ $enrollment->grade >= 75 ? 'success' : 'danger' }}">
                                                    {{ $enrollment->grade }}%
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('students.show', $enrollment->student) }}" 
                                                   class="btn btn-outline-info" title="View Student">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('enrollments.edit', $enrollment) }}" 
                                                   class="btn btn-outline-primary" title="Edit Enrollment">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No students enrolled</h5>
                        <p class="text-muted">Start by enrolling students in this course.</p>
                        <a href="{{ route('enrollments.create') }}?course_id={{ $course->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Enroll Student
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection