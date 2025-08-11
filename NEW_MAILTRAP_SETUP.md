# New Mailtrap Account Setup

## Steps:
1. Go to https://mailtrap.io/register
2. Create a new account with different email
3. Create a new inbox
4. Get the new SMTP credentials

## Update .env with new credentials:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=new-username-here
MAIL_PASSWORD=new-password-here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@jeruksawit.desa.id
MAIL_FROM_NAME="Desa Jeruksawit"
```

## After updating:
```bash
php artisan config:clear
php artisan test:mail
```
