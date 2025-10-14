# OG Tags in Backend (Laravel)

To add Open Graph tags to your Laravel backend pages:

## 1. Use the Layout
In your Blade views, extend the layout:
```blade
@extends('layouts.app')

@section('content')
    <!-- Your page content -->
@endsection
```

## 2. Set Dynamic OG Tags
In your controllers or view composers, set variables:
```php
// In a controller
public function show($id) {
    $item = Item::find($id);
    return view('item.show', [
        'item' => $item,
        'ogTitle' => $item->title,
        'ogDescription' => $item->description,
        'ogImage' => asset('images/' . $item->image)
    ]);
}
```

## 3. Place OG Image
Put your OG image at `backend/public/assets/og-image.jpg` (recommended size: 1200x630).

## 4. View Composer (Global)
To set default OG tags globally, create a view composer in `AppServiceProvider`:
```php
use Illuminate\Support\Facades\View;

public function boot() {
    View::composer('*', function ($view) {
        $view->with('ogTitle', config('app.name'));
        $view->with('ogDescription', 'Your site description');
        $view->with('ogImage', asset('assets/og-image.jpg'));
    });
}
```

## Validation
- Test with Facebook Debugger: https://developers.facebook.com/tools/debug/
- Ensure images are accessible at the URLs specified.