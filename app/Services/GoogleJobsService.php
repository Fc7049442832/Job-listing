<?php

namespace App\Services;

use Google_Client;
use Google_Service_CloudTalentSolution;
use Google_Service_CloudTalentSolution_Job;

class GoogleJobsService
{
    protected $client;

    public function __construct()
    {
        // Initialize the Google Client
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/google-service-account.json')); // Path to your service account JSON file
        $this->client->addScope(Google_Service_CloudTalentSolution::JOBS);
    }

    public function postJob($jobData)
    {
        // Initialize the Google Jobs API service
        $service = new Google_Service_CloudTalentSolution($this->client);

        try {
            // Build the job data object
            $job = new Google_Service_CloudTalentSolution_Job([
                'title' => $jobData['job_title'],
                'description' => $jobData['job_description'],
                'company' => 'Tech Radar',
                'applicationInfo' => [
                    'uris' => [$jobData['application_url']],
                ],
                'jobLocations' => [
                    [
                        'location' => $jobData['job_location'],
                    ],
                ],
                'employmentTypes' => [$jobData['employment_type']],
                'jobBenefits' => ['Benefits provided'],
            ]);

                // Post the job using the Jobs API
                $service->projects_jobs->create('techradar-421407', $job);

                return response()->json(['message' => 'Job posted to Google Jobs successfully.']);
            

        } catch (\Exception $e) {
            // Handle errors, log them, and return a meaningful message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}