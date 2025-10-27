@extends('layouts.app')

@section('title', 'Add Course - Student TPS')
@section('header', 'Add New Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Course Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course_code" class="form-label">Course Code <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('course_code') is-invalid @enderror" 
                                   id="course_code" 
                                   name="course_code" 
                                   value="{{ old('course_code') }}" 
                                   placeholder="e.g., CS101"
                                   required>
                            @error('course_code')
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
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('course_name') is-invalid @enderror" 
                               id="course_name" 
                               name="course_name" 
                               value="{{ old('course_name') }}" 
                               placeholder="e.g., Introduction to Computer Science"
                               required>
                        @error('course_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Course description and objectives...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="units" class="form-label">Units <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('units') is-invalid @enderror" 
                                   id="units" 
                                   name="units" 
                                   value="{{ old('units') }}" 
                                   min="1"
                                   max="10"
                                   required>
                            @error('units')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="fee" class="form-label">Course Fee (₱) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('fee') is-invalid @enderror" 
                                   id="fee" 
                                   name="fee" 
                                   value="{{ old('fee') }}" 
                                   min="0"
                                   step="0.01"
                                   placeholder="0.00"
                                   required>
                            @error('fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection