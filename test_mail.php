<?php

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('This is a test email from Desa Jeruksawit', function ($message) {
        $message->to('test@mailtrap.io')
            ->subject('Test Email - Desa Jeruksawit');
    });

    echo "Email sent successfully!\n";
} catch (Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
}
