@echo off
REM Queue Worker Auto-Start Script for Windows

REM Kill any existing queue workers
taskkill /f /im php.exe 2>nul

REM Start new queue worker in background
start /B php artisan queue:work --queue=emails --timeout=300 --sleep=3 --tries=3

echo Queue worker started in background
