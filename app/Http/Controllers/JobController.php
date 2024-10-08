<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\GoogleJobsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class JobController extends Controller
{
    //
    public function index()
    {
        // Fetch all jobs from the database and paginate them
        $jobs = Job::orderBy('created_at', 'desc')->paginate(10); // Display 10 jobs per page
        return view('index', compact('jobs'));
    }
    public function create()
    {
        return view('jobs.create'); // This returns the form view for creating a new job
    }

      // Post to Facebook Jobs
    public function postToFacebookJobs($jobData)
    {
          $pageId = '380658778451058'; // Replace with your Facebook Page ID
          $accessToken = 'EAAFaNQdFLHIBO3BkvoJ2szqSsuKhZCUtMiN8P8DAHwCwEUUyzHnRZAatRT8F5oZCLYQt3NmB1ZBp7ZCKgpg0TLP0eQfSFndDBZCUx5sAdOKXFs5z1fqHU47ZBZBFs2BvzoabqPIZB1dJli7J7aDMy9UNZCkl2tRyxJBrqb3yzjyhGD46CHMaR82IppwZAdqkbevATVSCBIzMG3fpxlPk1Qhy5j9seLWZBom74wWdaS6ZAFCrhDZCiI3QXZAP9P7UvpVrZAnA8QZDZD'; // Replace with the access token you obtained
                // Prepare the job details
        $postData = [
            'title' => $jobData['job_title'],
            'description' => $jobData['job_description'],
            'location' => $jobData['job_location'],
            'employment_type' => $jobData['employment_type'],
            'url' => $jobData['application_url'],
            'salary' => $jobData['salary_range'] ?? 'Not provided',
            'contact_email' => 'YOUR_CONTACT_EMAIL', // Contact email for applications
        ];

        // Post the job details to Facebook Graph API
        $response = Http::withToken($accessToken)->post("https://graph.facebook.com/v13.0/{$pageId}/jobs", $postData);

        // Check the response status and handle any errors
        if ($response->successful()) {
            return response()->json(['message' => 'Job posted to Facebook successfully.']);
        } else {
            return response()->json(['error' => $response->json()], $response->status());
        }
    }


    public function store(Request $request)
    {
        // Validate the job request data
        $validatedData = $request->validate([
            'job_title' => 'required',
            'job_description' => 'required',
            'company_name' => 'required',
            'job_location' => 'required',
            'employment_type' => 'required',
            'salary_range' => 'nullable',
            'application_url' => 'required|url',
            'expiry_date' => 'required|date',
        ]);
    
        // Save the validated data into the database
        $job = Job::create($validatedData);
    
        // Validate and get job data
        $validatedData = $request->validate([
            'job_title' => 'required',
            'job_description' => 'required',
            'job_location' => 'required',
            'employment_type' => 'required',
            'salary_range' => 'nullable',
            'application_url' => 'required|url',
        ]);

        // Post job data to Facebook
        $this->postToFacebookJobs($validatedData);
    
        // Google Job List Data Entry using GoogleJobsService
        // Here, you can use dependency injection or manually create the service
        $googleJobsService = new GoogleJobsService();
        $googleJobsService->postJob($validatedData);
    
        // Redirect back to the index route with a success message
        return redirect()->route('index')->with('success', 'Job listing created successfully and posted to Facebook and Google.');
    }
    

    // edit Function 
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.edit', compact('job'));
    }

    // update Function
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'job_title' => 'required',
            'job_description' => 'required',
            'company_name' => 'required',
            'job_location' => 'required',
            'employment_type' => 'required',
            'salary_range' => 'nullable',
            'application_url' => 'required|url',
            'expiry_date' => 'required|date',
        ]);
    
        $job = Job::findOrFail($id); // Find the job by ID
        $job->update($validatedData); // Update the job listing with the new data
    
        return redirect()->route('index')->with('success', 'Job updated successfully.');
    }

    // Show Function
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show',compact('job'));
    }

     // Method to delete a job
     public function destroy($id)
     {
         // Find the job by its ID
         $job = Job::findOrFail($id);
 
         // Delete the job
         $job->delete();
 
         // Redirect to the jobs list page with a success message
         return redirect()->route('index')->with('success', 'Job deleted successfully.');
     }

  
}
