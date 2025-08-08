#!/bin/bash
# Queue Worker Auto-Start Script

# Kill any existing queue workers
pkill -f "artisan queue:work"

# Start new queue worker in background
php artisan queue:work --queue=emails --timeout=300 --sleep=3 --tries=3 &

echo "Queue worker started in background"
