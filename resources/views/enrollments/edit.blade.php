@extends('layouts.app')

@section('title', 'Edit Enrollment - Student TPS')
@section('header', 'Edit Enrollment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Enrollment Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('enrollments.update', $enrollment) }}">
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
                                            {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id" 
                                    required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            data-fee="{{ $course->fee }}"
                                            {{ old('course_id', $enrollment->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Course Fee Display -->
                    <div class="alert alert-info" id="course-fee">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Course Fee:</strong> ₱<span id="fee-amount">{{ number_format($enrollment->course->fee, 2) }}</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="enrollment_date" class="form-label">Enrollment Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('enrollment_date') is-invalid @enderror" 
                                   id="enrollment_date" 
                                   name="enrollment_date" 
                                   value="{{ old('enrollment_date', $enrollment->enrollment_date->format('Y-m-d')) }}" 
                                   required>
                            @error('enrollment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">Select Status</option>
                                <option value="enrolled" {{ old('status', $enrollment->status) === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                <option value="completed" {{ old('status', $enrollment->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="dropped" {{ old('status', $enrollment->status) === 'dropped' ? 'selected' : '' }}>Dropped</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade (Optional)</label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control @error('grade') is-invalid @enderror" 
                                   id="grade" 
                                   name="grade" 
                                   value="{{ old('grade', $enrollment->grade) }}" 
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   placeholder="Enter grade">
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="form-text text-muted">Leave blank if no grade yet. Passing grade is 75%.</small>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Current Information Display -->
                    <div class="alert alert-light">
                        <h6 class="alert-heading">Current Enrollment Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Student:</strong> {{ $enrollment->student->full_name }}<br>
                                <strong>Course:</strong> {{ $enrollment->course->course_name }}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Original Date:</strong> {{ $enrollment->enrollment_date->format('M j, Y') }}<br>
                                <strong>Current Status:</strong> 
                                <span class="badge bg-{{ $enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'completed' ? 'primary' : 'secondary') }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('enrollments.show', $enrollment) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Enrollment
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
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('course_id');
    const feeAmount = document.getElementById('fee-amount');
    
    courseSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value && selectedOption.dataset.fee) {
            const fee = parseFloat(selectedOption.dataset.fee);
            feeAmount.textContent = fee.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    });
});
</script>
@endsection