@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <h1>Job Listings</h1>
        </div>
        <div class="col-2 text-center p-2">
            <a href="{{route('jobs.create')}}"class="btn btn-success">
            <img src="{{asset('images/add.jpg')}}" alt="add" width="35px">
            </a>
        </div>
    </div>
    

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($jobs->isEmpty())
        <p>No jobs available at the moment.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Employment Type</th>
                    <th>Actions</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>{{ $job->job_title }}</td>
                        <td>{{ $job->company_name }}</td>
                        <td>{{ $job->job_location }}</td>
                        <td>{{ $job->employment_type }}</td>
                      
                        <td>
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <!-- Form for deleting the job -->
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                @csrf
                                @method('DELETE') <!-- Method Spoofing to send a DELETE request -->
                
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        {{ $jobs->links() }}
    @endif
</div>
@endsection
