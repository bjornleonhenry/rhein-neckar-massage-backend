# CORS Configuration Guide

## Overview
This backend API is configured to handle Cross-Origin Resource Sharing (CORS) properly for both development and production environments.

## Configuration

### Development
For local development, CORS is set to allow all origins by default:
```env
CORS_ALLOWED_ORIGINS=*
```

### Production (Plesk or any web server)
For production deployment, you should explicitly specify allowed origins in your `.env` file:

```env
# Single domain
CORS_ALLOWED_ORIGINS=https://yourdomain.com

# Multiple domains (comma-separated, no spaces)
CORS_ALLOWED_ORIGINS=https://yourdomain.com,https://www.yourdomain.com,https://app.yourdomain.com
```

## How It Works

1. **Custom CORS Middleware** (`app/Http/Middleware/CorsMiddleware.php`):
   - Handles preflight OPTIONS requests
   - Adds proper CORS headers to all responses
   - Supports credentials (cookies, authorization headers)
   - Works with both API and storage routes

2. **CORS Config** (`config/cors.php`):
   - Defines which paths require CORS headers
   - Specifies allowed methods, headers, and origins
   - Configured to work with the custom middleware

3. **Bootstrap Configuration** (`bootstrap/app.php`):
   - Applies CORS middleware to both web and API routes
   - Ensures CORS headers are sent before any other processing

## Troubleshooting

### Issue: CORS errors on Plesk server
**Solution**: Add your frontend domain to the `.env` file:
```env
CORS_ALLOWED_ORIGINS=https://your-frontend-domain.com
```

### Issue: Images blocked by CORB (Cross-Origin Read Blocking)
**Solution**: 
1. Ensure storage path is included in CORS paths (already configured)
2. Make sure your web server (Apache/Nginx) isn't blocking the headers
3. For Plesk, check that `.htaccess` allows headers

### Issue: Credentials not working
**Solution**: 
- Ensure `supports_credentials` is `true` in `config/cors.php` (already set)
- Make sure frontend sends `credentials: 'include'` in fetch requests
- Verify the allowed origin matches exactly (including protocol and port)

## Apache/Nginx Configuration (Plesk)

### Apache (.htaccess)
If you need additional server-level CORS headers:
```apache
<IfModule mod_headers.c>
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, PATCH, DELETE, OPTIONS"
    Header always set Access-Control-Allow-Headers "Content-Type, X-Requested-With, Authorization, Accept, Origin, X-CSRF-TOKEN"
    Header always set Access-Control-Allow-Credentials "true"
</IfModule>
```

### Nginx
Add to your site configuration:
```nginx
add_header 'Access-Control-Allow-Origin' '*' always;
add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, PATCH, DELETE, OPTIONS' always;
add_header 'Access-Control-Allow-Headers' 'Content-Type, X-Requested-With, Authorization, Accept, Origin, X-CSRF-TOKEN' always;
add_header 'Access-Control-Allow-Credentials' 'true' always;
```

## Security Notes

⚠️ **Never use `CORS_ALLOWED_ORIGINS=*` in production!** 

Always specify your exact frontend domain(s) to prevent unauthorized access from other websites.

## Testing

Test your CORS configuration:
```bash
# Test from command line
curl -H "Origin: https://your-frontend-domain.com" \
     -H "Access-Control-Request-Method: GET" \
     -H "Access-Control-Request-Headers: Content-Type" \
     -X OPTIONS \
     https://your-backend-domain.com/api/angebots
```

You should see headers like:
```
Access-Control-Allow-Origin: https://your-frontend-domain.com
Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS
Access-Control-Allow-Credentials: true
```
