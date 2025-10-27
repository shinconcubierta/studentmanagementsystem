@extends('layouts.app')

@section('title', 'New Transaction - Student TPS')
@section('header', 'New Transaction')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Transaction Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    
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
                                            {{ old('student_id', request('student_id')) == $student->id ? 'selected' : '' }}>
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
                                <option value="payment" {{ old('transaction_type') === 'payment' ? 'selected' : '' }}>Payment</option>
                                <option value="refund" {{ old('transaction_type') === 'refund' ? 'selected' : '' }}>Refund</option>
                                <option value="fee" {{ old('transaction_type') === 'fee' ? 'selected' : '' }}>Fee/Charge</option>
                                <option value="adjustment" {{ old('transaction_type') === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                            </select>
                            @error('transaction_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Student Balance Display -->
                    <div class="alert alert-info" id="student-balance" style="display: none;">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Student Balance:</strong> ₱<span id="balance-amount">0.00</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount (₱) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" 
                                   name="amount" 
                                   value="{{ old('amount') }}" 
                                   min="0"
                                   step="0.01"
                                   placeholder="0.00"
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
                                   value="{{ old('transaction_date', date('Y-m-d')) }}" 
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
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', 'completed') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ old('status') === 'failed' ? 'selected' : '' }}>Failed</option>
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
                                  placeholder="Enter transaction details, payment method, reference number, etc.">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Quick Amount Buttons -->
                    <div class="mb-3">
                        <label class="form-label">Quick Amounts:</label><br>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(500)">₱500</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(1000)">₱1,000</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(2500)">₱2,500</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="setAmount(5000)">₱5,000</button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="setFullBalance()">Pay Balance</button>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Transaction
                        </button>
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
            balanceDiv.style.display = 'block';
            
            // Change alert color based on balance
            if (balance > 0) {
                balanceDiv.className = 'alert alert-warning';
            } else if (balance < 0) {
                balanceDiv.className = 'alert alert-success';
            } else {
                balanceDiv.className = 'alert alert-info';
            }
        } else {
            balanceDiv.style.display = 'none';
            currentBalance = 0;
        }
    });
    
    // Trigger change event if student is pre-selected
    if (studentSelect.value) {
        studentSelect.dispatchEvent(new Event('change'));
    }
});

function setAmount(amount) {
    document.getElementById('amount').value = amount.toFixed(2);
}

function setFullBalance() {
    if (currentBalance > 0) {
        document.getElementById('amount').value = currentBalance.toFixed(2);
    }
}
</script>
@endsection