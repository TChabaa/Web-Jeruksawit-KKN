# Sitemap XML Implementation - Desa Jeruksawit Website

## Overview

Implementasi sitemap XML menggunakan package **Spatie Laravel Sitemap** untuk meningkatkan SEO dan membantu search engines mengindex website Desa Jeruksawit dengan lebih efektif.

## Package Installation

```bash
composer require spatie/laravel-sitemap
```

## Features Implemented

### 1. Automated Sitemap Generation

-   **Command**: `php artisan sitemap:generate`
-   **Scheduled Task**: Otomatis generate setiap hari pukul 01:00 AM
-   **Location**: `public/sitemap.xml`

### 2. Static Pages Included

-   **Beranda** (`/`) - Priority: 1.0, Daily updates
-   **Tempat Wisata** (`/destinations`) - Priority: 0.9, Weekly updates
-   **UMKM** (`/umkm`) - Priority: 0.9, Weekly updates
-   **Artikel** (`/articles`) - Priority: 0.8, Daily updates
-   **Galeri** (`/galleries`) - Priority: 0.7, Weekly updates
-   **Tentang Kami** (`/about-us`) - Priority: 0.6, Monthly updates
-   **Layanan Surat** (`/layanan-surat`) - Priority: 0.8, Monthly updates

### 3. Dynamic Content Support

-   **Destinations**: Individual destination pages with image sitemaps
-   **UMKM**: Individual UMKM pages with product images
-   **Articles**: Individual article pages with article images
-   **Layanan Surat Forms**: All 12 surat form types

### 4. Image Sitemap Support

-   **Destination Images**: Up to 5 images per destination
-   **UMKM Images**: Up to 3 images per UMKM
-   **Article Images**: Up to 3 images per article
-   **Image Tags**: Proper image:image XML tags with captions

### 5. Advanced Features

-   **Last Modified Dates**: Dynamic berdasarkan updated_at dari database
-   **Change Frequency**: Optimized untuk setiap jenis konten
-   **Priority Setting**: Hierarki prioritas berdasarkan importance
-   **Error Handling**: Fallback mechanism jika command gagal

## File Structure

### Command File

```
app/Console/Commands/GenerateSitemap.php
```

### Controller Integration

```
app/Http/Controllers/FrontendController.php
- sitemap() method dengan fallback
- generateSitemapOnTheFly() untuk emergency generation
- generateBasicSitemap() untuk fallback
```

### Scheduler Integration

```
app/Console/Kernel.php
- Daily sitemap generation at 1 AM
- Prevents overlapping executions
- Single server execution only
```

### Route Configuration

```
routes/web.php
- GET /sitemap.xml
- GET /robots.txt
```

## Usage

### Manual Generation

```bash
php artisan sitemap:generate
```

### Access Sitemap

-   **URL**: `https://yourdomaincom/sitemap.xml`
-   **Format**: XML with proper namespaces
-   **Size**: Optimized untuk search engines

### Submit to Search Engines

#### Google Search Console

1. Login ke Google Search Console
2. Pilih property website
3. Go to Sitemaps section
4. Submit: `https://yourdomain.com/sitemap.xml`

#### Bing Webmaster Tools

1. Login ke Bing Webmaster Tools
2. Add website property
3. Submit sitemap URL

## XML Structure Example

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>https://yourdomain.com/destinations/nama-wisata</loc>
        <lastmod>2025-08-10T13:16:54+07:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        <image:image>
            <image:loc>https://yourdomain.com/storage/destinations/image.jpg</image:loc>
            <image:caption>Nama Wisata</image:caption>
        </image:image>
    </url>
</urlset>
```

## Monitoring & Maintenance

### Automatic Updates

-   **Scheduler**: Laravel Cron berjalan daily
-   **Content Changes**: Otomatis update saat ada perubahan content
-   **Last Modified**: Dynamic berdasarkan database timestamps

### Manual Monitoring

```bash
# Check if sitemap exists
ls -la public/sitemap.xml

# Check file size
du -h public/sitemap.xml

# View recent entries
tail -20 public/sitemap.xml

# Validate XML syntax
xmllint public/sitemap.xml
```

### Performance Optimization

-   **Image Limits**: Maksimal 5 images per destination, 3 per UMKM/article
-   **Eager Loading**: Menggunakan `with()` untuk menghindari N+1 queries
-   **Caching**: File-based caching via direct XML file

## Troubleshooting

### Common Issues

1. **Permission Error**

    ```bash
    chmod 755 public/
    chmod 644 public/sitemap.xml
    ```

2. **Memory Limit**

    - Increase PHP memory limit
    - Implement pagination for large datasets

3. **Missing Images**
    - Check storage symlink: `php artisan storage:link`
    - Verify image paths in database

### Debug Commands

```bash
# Test sitemap generation
php artisan sitemap:generate

# Check Laravel logs
tail -f storage/logs/laravel.log

# Verify routes
php artisan route:list | grep sitemap
```

## SEO Benefits

### Search Engine Optimization

-   **Faster Indexing**: Search engines dapat menemukan pages lebih cepat
-   **Image SEO**: Google Images dapat index gambar dengan proper captions
-   **Content Discovery**: Automatic discovery untuk new content
-   **Priority Signals**: Memberikan hint ke search engines tentang important pages

### Performance Benefits

-   **Reduced Crawl Budget**: Efficient crawling untuk search engines
-   **Better Mobile SEO**: Mobile-first indexing support
-   **Rich Snippets**: Enhanced search results dengan images

## Advanced Configuration

### Custom Priorities

```php
// High priority pages
'/' => 1.0,
'/destinations' => 0.9,
'/umkm' => 0.9,

// Medium priority
'/articles' => 0.8,
'/layanan-surat' => 0.8,

// Lower priority
'/galleries' => 0.7,
'/about-us' => 0.6,
'/forms/*' => 0.5
```

### Change Frequencies

-   **Daily**: Homepage, Articles
-   **Weekly**: Destinations, UMKM, Article details
-   **Monthly**: Static pages, Destination details
-   **Yearly**: Forms, Legal pages

## Integration with Other SEO Tools

### robots.txt

```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /login

Sitemap: https://yourdomain.com/sitemap.xml
```

### Google Analytics

-   Monitor sitemap submission status
-   Track indexed pages
-   Monitor organic traffic growth

### Search Console

-   Submit sitemap URL
-   Monitor indexing status
-   Check for crawl errors

---

**Created**: 10 Agustus 2025  
**Package**: Spatie Laravel Sitemap v7.3.6  
**Laravel Version**: 11.x  
**Status**: Production Ready
