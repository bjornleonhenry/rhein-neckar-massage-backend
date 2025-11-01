# Deploying to Plesk - CORS Fix Instructions

## Problem
When deploying to Plesk, you may encounter CORS (Cross-Origin Resource Sharing) errors like:
- "Cross-Origin Read Blocking (CORB) blocked cross-origin response"
- "CORS policy: No 'Access-Control-Allow-Origin' header is present"
- Images or API requests failing to load

## Solution

### Step 1: Configure Backend Environment

1. SSH into your Plesk server or use Plesk's file manager
2. Navigate to your Laravel backend directory
3. Edit the `.env` file:

```bash
# Add or update this line with your frontend domain(s)
CORS_ALLOWED_ORIGINS=https://your-frontend-domain.com

# For multiple domains, separate with commas (no spaces!)
CORS_ALLOWED_ORIGINS=https://your-domain.com,https://www.your-domain.com
```

4. Clear the config cache:
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 2: Verify Files Are Deployed

Make sure these files exist in your backend:
- `app/Http/Middleware/CorsMiddleware.php` (custom CORS middleware)
- `config/cors.php` (CORS configuration)
- `bootstrap/app.php` (should reference CorsMiddleware)

### Step 3: Check PHP Version

Ensure your Plesk domain is using PHP 8.1 or higher:
1. Go to Plesk panel
2. Select your domain
3. Click "PHP Settings"
4. Select PHP 8.1 or 8.2

### Step 4: Apache Configuration (if needed)

If you still have CORS issues, add this to your `.htaccess` in the `public` folder:

```apache
<IfModule mod_headers.c>
    # Handle preflight requests
    RewriteCond %{REQUEST_METHOD} OPTIONS
    RewriteRule ^(.*)$ $1 [R=200,L]
    
    # Set CORS headers
    Header always set Access-Control-Allow-Origin "%{HTTP_ORIGIN}e" env=HTTP_ORIGIN
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, PATCH, DELETE, OPTIONS"
    Header always set Access-Control-Allow-Headers "Content-Type, X-Requested-With, Authorization, Accept, Origin, X-CSRF-TOKEN"
    Header always set Access-Control-Allow-Credentials "true"
    Header always set Access-Control-Max-Age "86400"
</IfModule>
```

### Step 5: Test CORS

Test from your browser console:

```javascript
fetch('https://your-backend-domain.com/api/angebots', {
  method: 'GET',
  credentials: 'include',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log('Success:', data))
.catch(error => console.error('Error:', error));
```

## Troubleshooting

### Still getting CORS errors?

1. **Check browser console**: Look for the exact error message
2. **Verify origin**: Make sure the frontend domain in `.env` exactly matches (including https://)
3. **Check server logs**: Look in `storage/logs/laravel.log` for errors
4. **Clear all caches**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

### Images not loading (CORB)?

The new configuration includes the `storage/*` path in CORS handling. Make sure:
1. Images are served from `/storage/` URL
2. Storage link is created: `php artisan storage:link`
3. File permissions are correct (755 for directories, 644 for files)

### OPTIONS requests failing?

The custom middleware handles OPTIONS preflight requests. If still failing:
1. Check Apache/Nginx configuration
2. Verify mod_headers is enabled (Apache)
3. Check if any firewall/proxy is blocking OPTIONS

## Production Security

⚠️ **Important**: Never use `CORS_ALLOWED_ORIGINS=*` in production!

Always specify exact domains:
```env
# ✅ Good
CORS_ALLOWED_ORIGINS=https://mysite.com,https://www.mysite.com

# ❌ Bad (security risk)
CORS_ALLOWED_ORIGINS=*
```

## Quick Checklist

- [ ] `.env` has `CORS_ALLOWED_ORIGINS` set to frontend domain
- [ ] Config cache cleared
- [ ] PHP version is 8.1+
- [ ] Custom CorsMiddleware.php exists
- [ ] Storage link created
- [ ] Test API endpoint in browser console
- [ ] Check browser network tab for CORS headers
- [ ] Verify no server-level CORS blocks

## Support

If you continue to have issues:
1. Check the full documentation: `CORS_CONFIGURATION.md`
2. Verify all middleware files are properly deployed
3. Check Plesk logs: Websites & Domains → domain → Logs
4. Test with curl to verify server response:
   ```bash
   curl -I https://your-backend-domain.com/api/angebots
   ```
