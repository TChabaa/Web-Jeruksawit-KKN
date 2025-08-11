# cPanel Email Queue Setup Instructions

## For cPanel Hosting Environments Without Terminal Access

### 🔧 Setup Options:

#### Option 1: Web-Based Queue Management (Recommended)

1. Access the admin panel at: `/admin/email-queue`
2. Use the web interface to manually process emails
3. Monitor queue status and statistics
4. Send test emails to verify functionality

#### Option 2: cPanel Cron Jobs (Automated)

1. Go to cPanel → Cron Jobs
2. Add a new cron job with these settings:
    - **Frequency**: Every 5 minutes (`*/5 * * * *`)
    - **Command**: `php /home/yourusername/public_html/yoursite/artisan queue:auto-worker --max-runtime=240`
    - Replace `/home/yourusername/public_html/yoursite/` with your actual path

#### Option 3: Simple Cron for Limited Processing

If Option 2 doesn't work, try:

-   **Command**: `php /home/yourusername/public_html/yoursite/artisan queue:work --once --queue=emails --timeout=60`
-   **Frequency**: Every 2 minutes (`*/2 * * * *`)

### 📧 Email Configuration for Production:

1. **Update .env file**:

    ```
    MAIL_MAILER=smtp
    MAIL_HOST=your-smtp-server.com
    MAIL_PORT=587
    MAIL_USERNAME=your-email@yourdomain.com
    MAIL_PASSWORD=your-email-password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@jeruksawit.desa.id
    MAIL_FROM_NAME="Desa Jeruksawit"
    ```

2. **For cPanel Email**:
    ```
    MAIL_MAILER=smtp
    MAIL_HOST=mail.yourdomain.com
    MAIL_PORT=587
    MAIL_USERNAME=noreply@yourdomain.com
    MAIL_PASSWORD=your-cpanel-email-password
    MAIL_ENCRYPTION=tls
    ```

### 🚀 Testing:

1. Visit `/admin/email-queue` in your browser
2. Click "Send Test Email"
3. Click "Process Email Queue" to send queued emails
4. Monitor the activity log for results

### 🛡️ Anti-Spam Features Active:

-   ✅ Random delays (5-15 seconds between emails)
-   ✅ Rate limiting (max 30 emails/minute)
-   ✅ Automatic retries on failure
-   ✅ Dedicated email queue
-   ✅ Memory management and cleanup

### 📞 Support:

If you encounter issues:

1. Check the Laravel logs in `storage/logs/`
2. Verify email credentials in `.env`
3. Test with the web interface first
4. Contact your hosting provider for cron job support

### 🔄 Maintenance:

-   Check the email queue interface weekly
-   Clear failed jobs if they accumulate
-   Monitor email delivery rates
-   Update email credentials as needed
