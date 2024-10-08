
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center p-5">
        <div class="col-md-8 col-12">
            <h3 class="mb-4" >Create Job Post </h3>
            {{-- Job Add Form --}}
            <form action="{{ route('jobs.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="job_title" class="form-label">Job Title</label>
                    <input type="text" name="job_title" id="job_title" class="form-control @error('job_title') is-invalid @enderror" value="{{ old('job_title') }}" required>
                    @error('job_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="job_description" class="form-label">Job Description</label>
                    <textarea name="job_description" id="job_description" class="form-control @error('job_description') is-invalid @enderror" required>{{ old('job_description') }}</textarea>
                    @error('job_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
                    @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="job_location" class="form-label">Job Location</label>
                    <input type="text" name="job_location" id="job_location" class="form-control @error('job_location') is-invalid @enderror" value="{{ old('job_location') }}" required>
                    @error('job_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="employment_type" class="form-label">Employment Type</label>
                    <select name="employment_type" id="employment_type" class="form-select @error('employment_type') is-invalid @enderror" required>
                        <option value="">Select Employment Type</option>
                        <option value="Full-time" {{ old('employment_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Part-time" {{ old('employment_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                    @error('employment_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="salary_range" class="form-label">Salary Range (Optional)</label>
                    <input type="text" name="salary_range" id="salary_range" class="form-control @error('salary_range') is-invalid @enderror" value="{{ old('salary_range') }}">
                    @error('salary_range')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="application_url" class="form-label">Application URL</label>
                    <input type="url" name="application_url" id="application_url" class="form-control @error('application_url') is-invalid @enderror" value="{{ old('application_url') }}" required>
                    @error('application_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="expiry_date" class="form-label">Job Posting Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}" required>
                    @error('expiry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-primary">Create Job</button>
            </form>
        </div>
    </div>
    
@endsection