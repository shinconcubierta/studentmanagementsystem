@extends('layouts.app')

@section('title', 'Transactions - Student TPS')
@section('header', 'Transactions')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="{{ route('transactions.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Search transactions..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-danger ms-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <select name="type" class="form-select form-select-sm" onchange="filterTransactions()">
                    <option value="">All Types</option>
                    <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
                    <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>Refund</option>
                    <option value="fee" {{ request('type') === 'fee' ? 'selected' : '' }}>Fee</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm" onchange="filterTransactions()">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
                    <i class=></i>New Transaction
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Student</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>
                                    <strong>{{ $transaction->transaction_date->format('M j, Y') }}</strong><br>
                                    <small class="text-muted">{{ $transaction->transaction_date->format('g:i A') }}</small>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $transaction->student->full_name }}</strong><br>
                                        <small class="text-muted">{{ $transaction->student->student_id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-{{ $transaction->transaction_type === 'payment' ? 'credit-card' : ($transaction->transaction_type === 'refund' ? 'undo' : 'receipt') }} me-1"></i>
                                        {{ ucfirst($transaction->transaction_type) }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="fs-6 text-{{ $transaction->transaction_type === 'payment' ? 'success' : ($transaction->transaction_type === 'refund' ? 'danger' : 'warning') }}">
                                        @if($transaction->transaction_type === 'refund')
                                            -₱{{ number_format($transaction->amount, 2) }}
                                        @else
                                            ₱{{ number_format($transaction->amount, 2) }}
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                        <i class="fas fa-{{ $transaction->status === 'completed' ? 'check-circle' : ($transaction->status === 'pending' ? 'clock' : 'times-circle') }} me-1"></i>
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($transaction->description)
                                        <small>{{ Str::limit($transaction->description, 40) }}</small>
                                    @else
                                        <span class="text-muted">No description</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('transactions.show', $transaction) }}" 
                                           class="btn btn-outline-info" title="View">
                                            <i class=>Show</i>
                                        </a>
                                        <a href="{{ route('transactions.edit', $transaction) }}" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class=>Edit</i>
                                        </a>
                                        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this transaction?')">
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
                {{ $transactions->links('components.pagination') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No transactions found</h5>
                <p class="text-muted">
                    @if(request('search') || request('type') || request('status'))
                        No transactions match your search criteria.
                    @else
                        Start by creating your first transaction.
                    @endif
                </p>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                    <i class=></i>New Transaction
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
                <h4>₱{{ number_format($transactions->where('status', 'completed')->where('transaction_type', 'payment')->sum('amount'), 2) }}</h4>
                <small>Completed Payments</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4>{{ $transactions->where('status', 'pending')->count() }}</h4>
                <small>Pending Transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4>₱{{ number_format($transactions->where('status', 'completed')->where('transaction_type', 'refund')->sum('amount'), 2) }}</h4>
                <small>Total Refunds</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4>{{ $transactions->count() }}</h4>
                <small>Total Transactions</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterTransactions() {
    const typeSelect = document.querySelector('select[name="type"]');
    const statusSelect = document.querySelector('select[name="status"]');
    
    const url = new URL(window.location.href);
    
    if (typeSelect.value) {
        url.searchParams.set('type', typeSelect.value);
    } else {
        url.searchParams.delete('type');
    }
    
    if (statusSelect.value) {
        url.searchParams.set('status', statusSelect.value);
    } else {
        url.searchParams.delete('status');
    }
    
    window.location.href = url.toString();
}
</script>
@endsection