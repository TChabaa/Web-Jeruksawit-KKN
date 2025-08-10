#!/bin/bash

# cPanel Email Queue Processor
# Add this to your cPanel Cron Jobs with schedule: */5 * * * *
# Command: /bin/bash /path/to/your/site/process-email-queue.sh

# Change to your Laravel application directory
cd /home/yourusername/public_html/yoursite

# Run the queue processor with timeout protection
timeout 4m php artisan queue:auto-worker --max-runtime=240

# Alternative: Process a limited number of jobs
# php artisan queue:work --once --queue=emails --timeout=60 --memory=128

# Log the execution
echo "$(date): Email queue processed" >> storage/logs/cron-email-queue.log
