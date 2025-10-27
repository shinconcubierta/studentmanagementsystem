@extends('layouts.app')

@section('title', 'View Enrollment - Student TPS')
@section('header', 'Enrollment Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enrollment Information</h5>
                <span class="badge bg-{{ $enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'completed' ? 'primary' : 'secondary') }} fs-6">
                    {{ ucfirst($enrollment->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Student Information -->
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user me-2"></i>Student Information
                        </h6>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($enrollment->student->first_name, 0, 1) . substr($enrollment->student->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $enrollment->student->full_name }}</h5>
                                    <small class="text-muted">{{ $enrollment->student->student_id }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ $enrollment->student->email }}">{{ $enrollment->student->email }}</a>
                            </div>
                            <div class="col-sm-6">
                                <strong>Phone:</strong><br>
                                {{ $enrollment->student->phone ?? 'Not provided' }}
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <a href="{{ route('students.show', $enrollment->student) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Student Profile
                            </a>
                        </div>
                    </div>
                    
                    <!-- Course Information -->
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-book me-2"></i>Course Information
                        </h6>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $enrollment->course->course_name }}</h5>
                                    <small class="text-muted">{{ $enrollment->course->course_code }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Units:</strong><br>
                                <span class="badge bg-info">{{ $enrollment->course->units }} units</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>Course Fee:</strong><br>
                                <span class="text-success fs-5">₱{{ number_format($enrollment->course->fee, 2) }}</span>
                            </div>
                        </div>
                        
                        @if($enrollment->course->description)
                        <div class="mt-2">
                            <strong>Description:</strong><br>
                            <p class="text-muted small">{{ $enrollment->course->description }}</p>
                        </div>
                        @endif
                        
                        <div class="mt-2">
                            <a href="{{ route('courses.show', $enrollment->course) }}" 
                               class="btn btn-outline-success btn-sm">
                                <i class="fas fa-eye me-1"></i>View Course Details
                            </a>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <!-- Enrollment Details -->
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-info mb-3">
                            <i class="fas fa-clipboard-list me-2"></i>Enrollment Details
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <strong>Enrollment Date:</strong><br>
                                <i class="fas fa-calendar text-muted me-1"></i>
                                {{ $enrollment->enrollment_date->format('F j, Y') }}
                                <br><small class="text-muted">{{ $enrollment->enrollment_date->diffForHumans() }}</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <strong>Current Status:</strong><br>
                                <span class="badge bg-{{ $enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'completed' ? 'primary' : 'secondary') }} fs-6">
                                    <i class="fas fa-{{ $enrollment->status === 'enrolled' ? 'check-circle' : ($enrollment->status === 'completed' ? 'graduation-cap' : 'times-circle') }} me-1"></i>
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <strong>Current Grade:</strong><br>
                                @if($enrollment->grade)
                                    <span class="badge bg-{{ $enrollment->grade >= 75 ? 'success' : 'danger' }} fs-6">
                                        {{ $enrollment->grade }}%
                                    </span>
                                    @if($enrollment->grade >= 75)
                                        <small class="text-success d-block">Passing Grade</small>
                                    @else
                                        <small class="text-danger d-block">Below Passing</small>
                                    @endif
                                @else
                                    <span class="text-muted">No grade assigned</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Enrolled Since:</strong><br>
                                <i class="fas fa-clock text-muted me-1"></i>
                                {{ $enrollment->created_at->format('F j, Y g:i A') }}
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Last Updated:</strong><br>
                                <i class="fas fa-edit text-muted me-1"></i>
                                {{ $enrollment->updated_at->format('F j, Y g:i A') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Summary -->
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Progress Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    @if($enrollment->status === 'completed')
                                        <div class="text-success mb-2">
                                            <i class="fas fa-trophy fa-2x"></i>
                                        </div>
                                        <h6 class="text-success">Course Completed!</h6>
                                        @if($enrollment->grade)
                                            <p class="mb-0">Final Grade: <strong>{{ $enrollment->grade }}%</strong></p>
                                        @endif
                                    @elseif($enrollment->status === 'enrolled')
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-graduation-cap fa-2x"></i>
                                        </div>
                                        <h6 class="text-primary">Currently Enrolled</h6>
                                        @if($enrollment->grade)
                                            <p class="mb-0">Current Grade: <strong>{{ $enrollment->grade }}%</strong></p>
                                        @else
                                            <p class="mb-0 text-muted">No grade yet</p>
                                        @endif
                                    @else
                                        <div class="text-secondary mb-2">
                                            <i class="fas fa-pause-circle fa-2x"></i>
                                        </div>
                                        <h6 class="text-secondary">Course Dropped</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Enrollments
                    </a>
                    
                    <div>
                        <a href="{{ route('enrollments.edit', $enrollment) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Enrollment
                        </a>
                        
                        <form method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" 
                              class="d-inline ms-2" 
                              onsubmit="return confirm('Are you sure you want to delete this enrollment? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection