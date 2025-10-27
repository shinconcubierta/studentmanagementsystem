@extends('layouts.app')

@section('title', 'View Transaction - Student TPS')
@section('header', 'Transaction Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Transaction #{{ $transaction->id }}</h5>
                <div>
                    <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }} fs-6 me-2">
                        <i class="fas fa-{{ $transaction->status === 'completed' ? 'check-circle' : ($transaction->status === 'pending' ? 'clock' : 'times-circle') }} me-1"></i>
                        {{ ucfirst($transaction->status) }}
                    </span>
                    <span class="badge bg-info fs-6">
                        <i class="fas fa-{{ $transaction->transaction_type === 'payment' ? 'credit-card' : ($transaction->transaction_type === 'refund' ? 'undo' : 'receipt') }} me-1"></i>
                        {{ ucfirst($transaction->transaction_type) }}
                    </span>
                </div>
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
                                    {{ strtoupper(substr($transaction->student->first_name, 0, 1) . substr($transaction->student->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $transaction->student->full_name }}</h5>
                                    <small class="text-muted">{{ $transaction->student->student_id }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ $transaction->student->email }}">{{ $transaction->student->email }}</a>
                            </div>
                            <div class="col-sm-6">
                                <strong>Phone:</strong><br>
                                {{ $transaction->student->phone ?? 'Not provided' }}
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('students.show', $transaction->student) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Student Profile
                            </a>
                        </div>
                    </div>
                    
                    <!-- Transaction Information -->
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-credit-card me-2"></i>Transaction Information
                        </h6>
                        
                        <div class="mb-3 text-center">
                            <div class="display-4 fw-bold text-{{ $transaction->transaction_type === 'payment' ? 'success' : ($transaction->transaction_type === 'refund' ? 'danger' : 'warning') }}">
                                @if($transaction->transaction_type === 'refund')
                                    -₱{{ number_format($transaction->amount, 2) }}
                                @else
                                    ₱{{ number_format($transaction->amount, 2) }}
                                @endif
                            </div>
                            <small class="text-muted">{{ ucfirst($transaction->transaction_type) }} Amount</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <strong>Transaction Date:</strong><br>
                                <i class="fas fa-calendar text-muted me-1"></i>
                                {{ $transaction->transaction_date->format('F j, Y') }}
                                <br><small class="text-muted">{{ $transaction->transaction_date->format('g:i A') }}</small>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Status:</strong><br>
                                <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }} fs-6">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <strong>Created:</strong><br>
                                <i class="fas fa-clock text-muted me-1"></i>
                                {{ $transaction->created_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Last Updated:</strong><br>
                                <i class="fas fa-edit text-muted me-1"></i>
                                {{ $transaction->updated_at->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <!-- Description and Notes -->
                @if($transaction->description)
                <div class="mb-4">
                    <h6 class="text-info mb-3">
                        <i class="fas fa-sticky-note me-2"></i>Description & Notes
                    </h6>
                    <div class="alert alert-light">
                        <p class="mb-0">{{ $transaction->description }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Student Financial Summary -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-warning mb-3">
                            <i class="fas fa-calculator me-2"></i>Student Financial Summary
                        </h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center py-2">
                                        <h5 class="mb-0">₱{{ number_format($transaction->student->total_fees, 2) }}</h5>
                                        <small>Total Fees</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center py-2">
                                        <h5 class="mb-0">₱{{ number_format($transaction->student->total_paid, 2) }}</h5>
                                        <small>Total Paid</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-{{ ($transaction->student->total_fees - $transaction->student->total_paid) > 0 ? 'warning' : 'info' }} text-white">
                                    <div class="card-body text-center py-2">
                                        <h5 class="mb-0">₱{{ number_format($transaction->student->total_fees - $transaction->student->total_paid, 2) }}</h5>
                                        <small>Balance</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center py-2">
                                        <h5 class="mb-0">{{ $transaction->student->transactions->count() }}</h5>
                                        <small>Total Transactions</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($transaction->status === 'pending')
                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Pending Transaction:</strong> This transaction is still pending and has not been processed yet. You can edit it to change the status or update details.
                </div>
                @elseif($transaction->status === 'failed')
                <div class="alert alert-danger mt-4">
                    <i class="fas fa-times-circle me-2"></i>
                    <strong>Failed Transaction:</strong> This transaction failed to process. Please check the details and create a new transaction if needed.
                </div>
                @else
                <div class="alert alert-success mt-4">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Completed Transaction:</strong> This transaction has been successfully processed and applied to the student's account.
                </div>
                @endif
            </div>
            
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Transactions
                    </a>
                    
                    <div>
                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Transaction
                        </a>
                        
                        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" 
                              class="d-inline ms-2" 
                              onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
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