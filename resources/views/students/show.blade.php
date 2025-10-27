@extends('layouts.app')

@section('title', 'View Student - Student TPS')
@section('header', 'Student Details')

@section('content')
<div class="row">
    <!-- Student Information -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Student Information</h5>
                <span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($student->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                    </div>
                    <h4 class="mt-2 mb-0">{{ $student->full_name }}</h4>
                    <small class="text-muted">{{ $student->student_id }}</small>
                </div>
                
                <hr>
                
                <div class="mb-2">
                    <strong><i class="fas fa-envelope me-2"></i>Email:</strong><br>
                    <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                </div>
                
                @if($student->phone)
                <div class="mb-2">
                    <strong><i class="fas fa-phone me-2"></i>Phone:</strong><br>
                    <a href="tel:{{ $student->phone }}">{{ $student->phone }}</a>
                </div>
                @endif
                
                <div class="mb-2">
                    <strong><i class="fas fa-calendar me-2"></i>Birth Date:</strong><br>
                    {{ $student->birth_date->format('F j, Y') }}
                    <small class="text-muted">({{ $student->birth_date->age }} years old)</small>
                </div>
                
                @if($student->address)
                <div class="mb-2">
                    <strong><i class="fas fa-map-marker-alt me-2"></i>Address:</strong><br>
                    {{ $student->address }}
                </div>
                @endif
                
                <div class="mb-2">
                    <strong><i class="fas fa-clock me-2"></i>Registered:</strong><br>
                    {{ $student->created_at->format('F j, Y g:i A') }}
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Financial Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Financial Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-danger">₱{{ number_format($student->total_fees, 2) }}</h4>
                        <small class="text-muted">Total Fees</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">₱{{ number_format($student->total_paid, 2) }}</h4>
                        <small class="text-muted">Total Paid</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <h5 class="mb-0 text-{{ ($student->total_fees - $student->total_paid) > 0 ? 'warning' : 'success' }}">
                        ₱{{ number_format($student->total_fees - $student->total_paid, 2) }}
                    </h5>
                    <small class="text-muted">Balance</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enrollments and Transactions -->
    <div class="col-md-8">
        <!-- Enrollments -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Course Enrollments</h5>
                <a href="{{ route('enrollments.create') }}?student_id={{ $student->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Add Enrollment
                </a>
            </div>
            <div class="card-body">
                @if($student->enrollments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Course</th>
                                    <th class="text-center">Enrollment Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center">Fee</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->enrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <strong>{{ $enrollment->course->course_name }}</strong><br>
                                            <small class="text-muted">{{ $enrollment->course->course_code }}</small>
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
                                        <td>₱{{ number_format($enrollment->course->fee, 2) }}</td>
                                        <td>
                                            <a href="{{ route('enrollments.edit', $enrollment) }}" 
                                               class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">No course enrollments yet.</p>
                @endif
            </div>
        </div>
        
        <!-- Transactions -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Transaction History</h5>
                <a href="{{ route('transactions.create') }}?student_id={{ $student->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Add Transaction
                </a>
            </div>
            <div class="card-body">
                @if($student->transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->transactions->sortByDesc('transaction_date') as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_date->format('M j, Y') }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst($transaction->transaction_type) }}
                                            </span>
                                        </td>
                                        <td class="text-{{ $transaction->transaction_type === 'payment' ? 'success' : 'danger' }}">
                                            ₱{{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $transaction->description ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('transactions.edit', $transaction) }}" 
                                               class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">No transactions yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection