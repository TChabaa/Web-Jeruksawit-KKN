<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email Queue Management - Desa Jeruksawit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="fas fa-envelope text-primary"></i>
                    Email Queue Management
                    <small class="text-muted">(cPanel Friendly)</small>
                </h1>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-clock"></i> Pending Jobs</h5>
                                <h3 id="pending-count">{{ $stats['pending_jobs'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-exclamation-triangle"></i> Failed Jobs</h5>
                                <h3 id="failed-count">{{ $stats['failed_jobs'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-check-circle"></i> Status</h5>
                                <h6 id="status">Ready</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-cogs"></i> Queue Controls</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <button id="process-queue" class="btn btn-primary btn-lg mb-2 w-100">
                                    <i class="fas fa-play"></i> Process Email Queue
                                </button>
                                <button id="refresh-stats" class="btn btn-info btn-lg mb-2 w-100">
                                    <i class="fas fa-sync"></i> Refresh Statistics
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button id="clear-failed" class="btn btn-warning btn-lg mb-2 w-100">
                                    <i class="fas fa-trash"></i> Clear Failed Jobs
                                </button>
                                <button id="test-email" class="btn btn-success btn-lg mb-2 w-100">
                                    <i class="fas fa-paper-plane"></i> Send Test Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Test Email Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-envelope-open"></i> Test Email</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="email" id="test-email-address" class="form-control"
                                    placeholder="Enter email address for testing" value="admin@jeruksawit.desa.id">
                            </div>
                            <div class="col-md-4">
                                <button id="send-test" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-paper-plane"></i> Send Test
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Log Output -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-terminal"></i> Activity Log</h5>
                    </div>
                    <div class="card-body">
                        <div id="log-output"
                            style="height: 300px; overflow-y: auto; background: #f8f9fa; padding: 15px; border-radius: 5px;">
                            <div class="text-muted">Ready to process emails... Click "Process Email Queue" to start.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle"></i> cPanel Hosting Instructions:</h6>
                    <ul class="mb-0">
                        <li><strong>Process Queue:</strong> Click the button above to manually process pending emails
                        </li>
                        <li><strong>Automatic Processing:</strong> Set up a cPanel Cron Job to run: <code>php
                                /path/to/your/site/artisan queue:auto-worker --max-runtime=300</code></li>
                        <li><strong>Recommended Cron Schedule:</strong> Every 5 minutes: <code>*/5 * * * *</code></li>
                        <li><strong>Alternative:</strong> Use this web interface to manually process emails when needed
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addLog(message, type = 'info') {
            const logOutput = document.getElementById('log-output');
            const timestamp = new Date().toLocaleTimeString();
            const alertClass = type === 'error' ? 'alert-danger' : type === 'success' ? 'alert-success' : 'alert-info';

            logOutput.innerHTML += `
                <div class="alert ${alertClass} alert-sm mb-2">
                    <small><strong>[${timestamp}]</strong> ${message}</small>
                </div>
            `;
            logOutput.scrollTop = logOutput.scrollHeight;
        }

        // Process Queue
        document.getElementById('process-queue').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            addLog('Starting to process email queue...', 'info');

            fetch('/admin/email-queue/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addLog(data.message, 'success');
                        refreshStats();
                    } else {
                        addLog(data.message, 'error');
                    }
                })
                .catch(error => {
                    addLog('Error: ' + error.message, 'error');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-play"></i> Process Email Queue';
                });
        });

        // Refresh Stats
        document.getElementById('refresh-stats').addEventListener('click', refreshStats);

        function refreshStats() {
            addLog('Refreshing statistics...', 'info');

            fetch('/admin/email-queue/stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('pending-count').textContent = data.stats.pending_jobs;
                        document.getElementById('failed-count').textContent = data.stats.failed_jobs;
                        addLog('Statistics updated successfully', 'success');
                    } else {
                        addLog('Error refreshing stats: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    addLog('Error: ' + error.message, 'error');
                });
        }

        // Clear Failed Jobs
        document.getElementById('clear-failed').addEventListener('click', function() {
            if (confirm('Are you sure you want to clear all failed jobs?')) {
                addLog('Clearing failed jobs...', 'info');

                fetch('/admin/email-queue/clear-failed', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            addLog(data.message, 'success');
                            refreshStats();
                        } else {
                            addLog(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        addLog('Error: ' + error.message, 'error');
                    });
            }
        });

        // Send Test Email
        document.getElementById('send-test').addEventListener('click', function() {
            const email = document.getElementById('test-email-address').value;

            if (!email) {
                addLog('Please enter an email address', 'error');
                return;
            }

            addLog(`Sending test email to ${email}...`, 'info');

            fetch('/admin/email-queue/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addLog(data.message, 'success');
                        refreshStats();
                    } else {
                        addLog(data.message, 'error');
                    }
                })
                .catch(error => {
                    addLog('Error: ' + error.message, 'error');
                });
        });

        // Auto-refresh stats every 30 seconds
        setInterval(refreshStats, 30000);
    </script>
</body>

</html>
