# Gmail SMTP Configuration for Production

## Step 1: Enable 2-Factor Authentication on Gmail
1. Go to your Google Account settings
2. Enable 2-Factor Authentication

## Step 2: Generate App Password
1. Go to Google Account → Security → 2-Step Verification
2. Click "App passwords"
3. Generate a new app password for "Mail"
4. Copy the 16-character password

## Step 3: Update .env file
Replace your current MAIL settings with:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@jeruksawit.desa.id
MAIL_FROM_NAME="Desa Jeruksawit"
```

## Alternative SMTP Providers:

### Option A: SendGrid (Free: 100 emails/day)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

### Option B: Mailgun (Free: 5,000 emails/month)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-username
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls
```

### Option C: cPanel Email (If using shared hosting)
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your-cpanel-email-password
MAIL_ENCRYPTION=tls
```

## After updating .env:
1. Run: `php artisan config:clear`
2. Test: `php artisan test:mail`
