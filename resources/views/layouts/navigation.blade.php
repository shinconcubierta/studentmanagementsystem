<nav class="nav flex-column py-3">
    <div class="text-center mb-4">
        <h4 class="text-white">Student TPS</h4>
        <small class="text-muted">Transaction Processing System</small>
    </div>
    
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
       href="{{ route('dashboard') }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
    
    <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" 
       href="{{ route('students.index') }}">
        <i class="fas fa-users me-2"></i>
        Students
    </a>
    
    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" 
       href="{{ route('courses.index') }}">
        <i class="fas fa-book me-2"></i>
        Courses
    </a>
    
    <a class="nav-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}" 
       href="{{ route('enrollments.index') }}">
        <i class="fas fa-user-graduate me-2"></i>
        Enrollments
    </a>
    
    <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" 
       href="{{ route('transactions.index') }}">
        <i class="fas fa-credit-card me-2"></i>
        Transactions
    </a>
</nav>