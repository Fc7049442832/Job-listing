@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Job View</h1>

    <div class="row p-2">
        <h3>{{ $job->job_title }}</h3>
        <p><strong>Company:</strong> {{ $job->company_name }}</p>
        <p><strong>Location:</strong> {{ $job->job_location }}</p>
        <p><strong>Employment Type:</strong> {{ $job->employment_type }}</p>
        <p><strong>Salary Range:</strong> {{ $job->salary_range ?? 'Not provided' }}</p>
        <p><strong>Application URL:</strong> <a href="{{ $job->application_url }}" target="_blank">{{ $job->application_url }}</a></p>
        <p><strong>Expiry Date:</strong> {{ $job->expiry_date->format('d M Y') }}</p>
        <p>{{ $job->job_description }}</p>


         <!-- JSON-LD Structured Data -->
        <script type="application/ld+json">
            {
            "@context": "http://schema.org",
            "@type": "JobPosting",
            "title": "{{ $job->job_title }}",
            "description": "{{ $job->job_description }}",
            "datePosted": "{{ $job->created_at->format('Y-m-d') }}",
            "validThrough": "{{ $job->expiry_date->format('Y-m-d') }}",
            "employmentType": "{{ strtoupper(str_replace('-', '_', $job->employment_type)) }}",
            "hiringOrganization": {
                "@type": "Organization",
                "name": "Tech Radar IT Services",
                "sameAs": "https://techradar.site",
                "logo": "https://techradar.site/logo.png"
            },
            "jobLocation": {
                "@type": "Place",
                "address": {
                "@type": "PostalAddress",
                "addressLocality": "{{ $job->job_location }}",
                "addressRegion": "Your Region",
                "addressCountry": "India"
                }
            },
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "Rupees",
                "value": {
                "@type": "QuantitativeValue",
                "value": "{{ $job->salary_range ?? 0 }}",
                "unitText": "YEAR"
                }
            },
            "url": "{{ $job->application_url }}"
            }
        </script>
    </div>
</div>
@endsection
