<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Queue Performance Optimization
    |--------------------------------------------------------------------------
    |
    | Configuration for optimizing queue processing performance
    |
    */

    'pdf_cache_ttl' => env('PDF_CACHE_TTL', 24), // Hours to cache PDFs
    'memory_limit' => env('PDF_MEMORY_LIMIT', '512M'), // Memory limit for PDF generation
    'timeout' => env('QUEUE_TIMEOUT', 300), // 5 minutes timeout for jobs

    'retry_delays' => [
        'approval' => [10, 30, 60], // Retry delays for approval emails (seconds)
        'rejection' => [5, 15, 30], // Retry delays for rejection emails (seconds)
        'submission' => [5, 15, 30], // Retry delays for submission emails (seconds)
    ],

    'queue_names' => [
        'emails' => 'emails', // Dedicated queue for email processing
        'pdf' => 'pdf', // Dedicated queue for PDF generation
        'default' => 'default',
    ],

    'batch_processing' => [
        'enabled' => env('BATCH_PROCESSING_ENABLED', true),
        'chunk_size' => env('BATCH_CHUNK_SIZE', 50), // Process emails in batches
    ],

    'pdf_optimization' => [
        'enable_compression' => env('PDF_COMPRESSION', true),
        'quality' => env('PDF_QUALITY', 'medium'), // low, medium, high
        'temp_cleanup' => env('PDF_TEMP_CLEANUP', true),
    ],
];
