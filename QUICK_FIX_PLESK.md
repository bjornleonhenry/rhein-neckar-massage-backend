# Quick Fix for rhein-neckar-massage.de CORS Issue

## Immediate Solution for Plesk

### Step 1: Update .env file on Plesk Backend

SSH into your Plesk server or use File Manager and edit the `.env` file in your Laravel backend root directory:

```env
# Add this line (or update if it exists)
CORS_ALLOWED_ORIGINS=https://rhein-neckar-massage.de,https://www.rhein-neckar-massage.de
```

### Step 2: Clear Laravel Cache

Run these commands via SSH or Plesk's command line:

```bash
cd /path/to/your/backend
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Step 3: Verify .htaccess in public folder

Make sure your `public/.htaccess` has this section (add if missing):

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

<IfModule mod_headers.c>
    # Handle CORS for API requests
    Header always set Access-Control-Allow-Origin "%{HTTP_ORIGIN}e" env=HTTP_ORIGIN
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, PATCH, DELETE, OPTIONS"
    Header always set Access-Control-Allow-Headers "Content-Type, X-Requested-With, Authorization, Accept, Origin, X-CSRF-TOKEN"
    Header always set Access-Control-Allow-Credentials "true"
    Header always set Access-Control-Max-Age "86400"
    
    # Handle preflight
    RewriteCond %{REQUEST_METHOD} OPTIONS
    RewriteRule ^(.*)$ $1 [R=200,L]
</IfModule>
```

### Step 4: Check PHP Version

In Plesk:
1. Go to your domain
2. Click "PHP Settings"
3. Ensure PHP 8.1 or 8.2 is selected

### Step 5: Test the API

Open browser console on https://rhein-neckar-massage.de/mieterinnen and run:

```javascript
fetch('https://your-backend-domain.com/api/profiles', {
  method: 'GET',
  credentials: 'include',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})
.then(response => {
  console.log('Response status:', response.status);
  console.log('CORS headers:', {
    'access-control-allow-origin': response.headers.get('access-control-allow-origin'),
    'access-control-allow-credentials': response.headers.get('access-control-allow-credentials')
  });
  return response.json();
})
.then(data => console.log('Data:', data))
.catch(error => console.error('Error:', error));
```

## If Still Having Issues

### Check 1: Verify Backend Domain in Frontend .env

Make sure your frontend `.env` (or build environment) has:
```env
VITE_API_BASE=https://your-backend-domain.com/api
```

### Check 2: Check Apache Modules

Ensure these Apache modules are enabled in Plesk:
- mod_headers
- mod_rewrite

### Check 3: Look at Browser Console

1. Open https://rhein-neckar-massage.de/mieterinnen
2. Open Developer Tools (F12)
3. Go to Network tab
4. Look for the `/profiles` request
5. Check the response headers - you should see:
   - `Access-Control-Allow-Origin: https://rhein-neckar-massage.de`
   - `Access-Control-Allow-Credentials: true`

### Check 4: Server Logs

In Plesk, check:
- Websites & Domains → domain → Logs
- Look for any 500 errors or PHP errors

## Expected Result

After following these steps, you should:
- ✅ See profiles loading on /mieterinnen page
- ✅ No CORS errors in browser console
- ✅ Images loading correctly
- ✅ All API calls working

## Common Mistakes to Avoid

❌ Using `http://` instead of `https://` in CORS_ALLOWED_ORIGINS  
❌ Having spaces in the comma-separated list  
❌ Not clearing cache after changing .env  
❌ Wrong backend URL in frontend environment  

## Need More Help?

If you're still seeing CORS errors:
1. Share the exact error from browser console
2. Share the Network tab request/response headers
3. Verify which specific request is failing (API call or image?)
