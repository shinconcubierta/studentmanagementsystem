@extends('layouts.app')

@section('title', 'Enrollments - Student TPS')
@section('header', 'Enrollments')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <form method="GET" action="{{ route('enrollments.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Search enrollments..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('enrollments.index') }}" class="btn btn-outline-danger ms-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('enrollments.create') }}" class="btn btn-primary">
            <i class=></i>New Enrollment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($enrollments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Student</th>
                            <th class="text-center">Course</th>
                            <th class="text-center">Enrollment Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Course Fee</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $enrollment->student->full_name }}</strong><br>
                                        <small class="text-muted">{{ $enrollment->student->student_id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $enrollment->course->course_name }}</strong><br>
                                        <small class="text-muted">{{ $enrollment->course->course_code }} • {{ $enrollment->course->units }} units</small>
                                    </div>
                                </td>
                                <td>{{ $enrollment->enrollment_date->format('M j, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'completed' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($enrollment->grade)
                                        <span class="badge bg-{{ $enrollment->grade >= 75 ? 'success' : 'danger' }} fs-6">
                                            {{ $enrollment->grade }}%
                                        </span>
                                    @else
                                        <span class="text-muted">No grade</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-success">₱{{ number_format($enrollment->course->fee, 2) }}</strong>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('enrollments.show', $enrollment) }}" 
                                           class="btn btn-outline-info" title="View">
                                            <i class=>Show</i>
                                        </a>
                                        <a href="{{ route('enrollments.edit', $enrollment) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class=>Edit</i>
                                        </a>
                                        <form method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
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
                {{ $enrollments->links('components.pagination') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No enrollments found</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No enrollments match your search criteria.
                    @else
                        Start by creating your first enrollment.
                    @endif
                </p>
                <a href="{{ route('enrollments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Enrollment
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3>{{ $enrollments->where('status', 'enrolled')->count() }}</h3>
                <small>Active Enrollments</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3>{{ $enrollments->where('status', 'completed')->count() }}</h3>
                <small>Completed</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h3>{{ $enrollments->where('status', 'dropped')->count() }}</h3>
                <small>Dropped</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3>₱{{ number_format($enrollments->sum(function($e) { return $e->course->fee; }), 2) }}</h3>
                <small>Total Revenue</small>
            </div>
        </div>
    </div>
</div>
@endsection