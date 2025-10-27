@extends('layouts.app')

@section('title', 'Dashboard - Student TPS')
@section('header', 'Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-3">
        <div class="card bg-student">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Students</h6>
                        <h3>{{ number_format($totalStudents) }}</h3>
                        <small>{{ $activeStudents }} active</small>
                    </div>
                    <i class="fas fa-users fa-2x opacity-100"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-course">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Courses</h6>
                        <h3>{{ number_format($totalCourses) }}</h3>
                        <small>{{ $activeCourses }} active</small>
                    </div>
                    <i class="fas fa-book fa-2x opacity-100"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-enrollment">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Enrollments</h6>
                        <h3>{{ number_format($totalEnrollments) }}</h3>
                        <small>{{ $activeEnrollments }} active</small>
                    </div>
                    <i class="fas fa-user-graduate fa-2x opacity-100"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-revenue">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Revenue</h6>
                        <h3>₱{{ number_format($totalRevenue, 2) }}</h3>
                        <small>{{ $pendingTransactions }} pending</small>
                    </div>
                    <i class="fas fa-peso-sign fa-2x opacity-100"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Enrollments -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Enrollments</h5>
                <a href="{{ route('enrollments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentEnrollments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentEnrollments as $enrollment)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $enrollment->student->full_name }}</strong><br>
                                    <small class="text-muted">{{ $enrollment->course->course_name }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $enrollment->status === 'enrolled' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span><br>
                                    <small class="text-muted">{{ $enrollment->enrollment_date->format('M j, Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-3">No recent enrollments</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Transactions</h5>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentTransactions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentTransactions as $transaction)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $transaction->student->full_name }}</strong><br>
                                    <small class="text-muted">{{ ucfirst($transaction->transaction_type) }}</small>
                                </div>
                                <div class="text-end">
                                    <strong class="text-{{ $transaction->transaction_type === 'payment' ? 'success' : 'danger' }}">
                                        ₱{{ number_format($transaction->amount, 2) }}
                                    </strong><br>
                                    <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-3">No recent transactions</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('students.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Add Student
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('courses.create') }}" class="btn btn-outline-success w-100">
                            <i class=></i>Add Course
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('enrollments.create') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-user-graduate me-2"></i>New Enrollment
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('transactions.create') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-credit-card me-2"></i>New Transaction
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection