@extends('layouts.app')

@section('title', 'Edit Transaction - Student TPS')
@section('header', 'Edit Transaction')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Transaction Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                            <select class="form-select @error('student_id') is-invalid @enderror" 
                                    id="student_id" 
                                    name="student_id" 
                                    required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                            data-balance="{{ $student->total_fees - $student->total_paid }}"
                                            {{ old('student_id', $transaction->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="transaction_type" class="form-label">Transaction Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('transaction_type') is-invalid @enderror" 
                                    id="transaction_type" 
                                    name="transaction_type" 
                                    required>
                                <option value="">Select Type</option>
                                <option value="payment" {{ old('transaction_type', $transaction->transaction_type) === 'payment' ? 'selected' : '' }}>Payment</option>
                                <option value="refund" {{ old('transaction_type', $transaction->transaction_type) === 'refund' ? 'selected' : '' }}>Refund</option>
                                <option value="fee" {{ old('transaction_type', $transaction->transaction_type) === 'fee' ? 'selected' : '' }}>Fee/Charge</option>
                                <option value="adjustment" {{ old('transaction_type', $transaction->transaction_type) === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                            </select>
                            @error('transaction_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Student Balance Display -->
                    <div class="alert alert-info" id="student-balance">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Student Balance:</strong> ₱<span id="balance-amount">{{ number_format($transaction->student->total_fees - $transaction->student->total_paid, 2) }}</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount (₱) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" 
                                   name="amount" 
                                   value="{{ old('amount', $transaction->amount) }}" 
                                   min="0"
                                   step="0.01"
                                   required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="transaction_date" class="form-label">Transaction Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('transaction_date') is-invalid @enderror" 
                                   id="transaction_date" 
                                   name="transaction_date" 
                                   value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" 
                                   required>
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $transaction->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', $transaction->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ old('status', $transaction->status) === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Enter transaction details, payment method, reference number, etc.">{{ old('description', $transaction->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Current Transaction Info -->
                    <div class="alert alert-light">
                        <h6 class="alert-heading">Current Transaction Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Student:</strong> {{ $transaction->student->full_name }}<br>
                                <strong>Type:</strong> {{ ucfirst($transaction->transaction_type) }}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Original Amount:</strong> ₱{{ number_format($transaction->amount, 2) }}<br>
                                <strong>Current Status:</strong> 
                                <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($transaction->status === 'completed')
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This transaction is already completed. Changes may affect the student's account balance and financial records.
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Transaction
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentBalance = 0;

document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student_id');
    const balanceDiv = document.getElementById('student-balance');
    const balanceAmount = document.getElementById('balance-amount');
    
    studentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value && selectedOption.dataset.balance) {
            const balance = parseFloat(selectedOption.dataset.balance);
            currentBalance = balance;
            balanceAmount.textContent = balance.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            // Change alert color based on balance
            if (balance > 0) {
                balanceDiv.className = 'alert alert-warning';
            } else if (balance < 0) {
                balanceDiv.className = 'alert alert-success';
            } else {
                balanceDiv.className = 'alert alert-info';
            }
        }
    });
    
    // Set initial balance
    const selectedOption = studentSelect.options[studentSelect.selectedIndex];
    if (selectedOption.dataset.balance) {
        currentBalance = parseFloat(selectedOption.dataset.balance);
    }
});
</script>
@endsection