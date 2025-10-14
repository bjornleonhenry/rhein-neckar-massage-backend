<?php

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Str;
use App\Models\LanguageKey;

function frontendUrl($path = null, $parameters = []): UrlGenerator|string
{
    return with(clone url(), static function (UrlGenerator $urlGenerator) use ($path, $parameters) {
        $root = config('app.frontend_url');

        $urlGenerator->useOrigin($root);

        if (is_null($path)) {
            return $urlGenerator;
        }

        $secure = Str::startsWith($root, 'https://');

        return $urlGenerator->to($path, $parameters, $secure);
    });
}

/**
 * Get a translation value for a specific key and language
 *
 * @param string $key The translation key
 * @param string $lang The language code (defaults to current app locale)
 * @param string|null $default Default value if translation not found
 * @return string|null
 */
function trans_lang(string $key, ?string $lang = null, ?string $default = null): ?string
{
    $lang = $lang ?: app()->getLocale();
    // Prefer active translation from language_keys -> language_strings
    $languageKey = LanguageKey::where('key', $key)->where('is_active', true)->first();
    if (! $languageKey) {
        return $default;
    }

    $translation = $languageKey->translations()->where('lang', $lang)->where('is_active', true)->first();
    if ($translation) {
        return $translation->value;
    }

    // fallback to default value on the key or provided default
    return $languageKey->default ?? $default;
}

/**
 * Get a translation with fallback to default value
 *
 * @param string $key The translation key
 * @param string $lang The language code
 * @return string|null
 */
function trans_lang_with_default(string $key, string $lang): ?string
{
    $languageKey = LanguageKey::where('key', $key)->where('is_active', true)->first();
    if (! $languageKey) {
        return null;
    }

    $translation = $languageKey->translations()->where('lang', $lang)->where('is_active', true)->first();
    if ($translation) {
        return $translation->value;
    }

    // Fallback to English translation or key default
    $en = $languageKey->translations()->where('lang', 'en')->where('is_active', true)->first();
    return $en?->value ?? $languageKey->default;
}

/**
 * Get all translations for a specific key
 *
 * @param string $key The translation key
 * @return \Illuminate\Database\Eloquent\Collection
 */
function trans_lang_all(string $key): \Illuminate\Database\Eloquent\Collection
{
    $languageKey = LanguageKey::where('key', $key)->where('is_active', true)->first();
    if (! $languageKey) {
        return collect();
    }

    return $languageKey->translations()->where('is_active', true)->get();
}

/**
 * Get translations by type
 *
 * @param string $type The translation type
 * @param string $lang The language code
 * @return \Illuminate\Database\Eloquent\Collection
 */
function trans_lang_by_type(string $type, ?string $lang = null): \Illuminate\Database\Eloquent\Collection
{
    $lang = $lang ?: app()->getLocale();
    return LanguageKey::where('type', $type)
        ->where('is_active', true)
        ->with(['translations' => function ($q) use ($lang) { $q->where('lang', $lang)->where('is_active', true); }])
        ->get()
        ->mapWithKeys(fn($key) => [$key->key => ($key->translations->first()?->value ?? $key->default)]);
}

/**
 * Get translations with specific tags
 *
 * @param array $tags Array of tags to search for
 * @param string $lang The language code
 * @return \Illuminate\Database\Eloquent\Collection
 */
function trans_lang_by_tags(array $tags, ?string $lang = null): \Illuminate\Database\Eloquent\Collection
{
    $lang = $lang ?: app()->getLocale();
    return LanguageKey::whereJsonContains('tags', $tags)
        ->where('is_active', true)
        ->with(['translations' => function ($q) use ($lang) { $q->where('lang', $lang)->where('is_active', true); }])
        ->get()
        ->mapWithKeys(fn($key) => [$key->key => ($key->translations->first()?->value ?? $key->default)]);
}
