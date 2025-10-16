<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LanguageString extends Model
{
    protected $fillable = [
        'language_key_id',
        'lang',
        'string',
        'value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the language key this translation belongs to
     */
    public function languageKey(): BelongsTo
    {
        return $this->belongsTo(LanguageKey::class, 'language_key_id');
    }

    /**
     * Scope to get only active translations
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope to get translations for a specific language
     */
    public function scopeForLanguage(Builder $query, string $lang): void
    {
        $query->where('lang', $lang);
    }

    /**
     * Get translation value for a specific key and language
     */
    public static function getTranslation(string $key, string $lang, ?string $default = null): ?string
    {
        $translation = static::join('language_keys', 'language_strings.language_key_id', '=', 'language_keys.id')
            ->where('language_keys.key', $key)
            ->where('language_strings.lang', $lang)
            ->where('language_strings.is_active', true)
            ->where('language_keys.is_active', true)
            ->select('language_strings.value')
            ->first();

        return $translation?->value ?? $default;
    }

    /**
     * Get all translations for a specific key across languages
     */
    public static function getTranslations(string $key): \Illuminate\Database\Eloquent\Collection
    {
        return static::join('language_keys', 'language_strings.language_key_id', '=', 'language_keys.id')
            ->where('language_keys.key', $key)
            ->where('language_strings.is_active', true)
            ->where('language_keys.is_active', true)
            ->select('language_strings.*')
            ->get();
    }

    /**
     * Get available types
     */
    public static function getAvailableTypes(): array
    {
        return [
            'text' => 'Text',
            'button' => 'Button',
            'title' => 'Title',
            'nav' => 'Navigation',
            'footer' => 'Footer',
            'header' => 'Header',
            'page' => 'Page',
            'admin' => 'Admin',
            'component' => 'Component',
            'alert' => 'Alert',
            'contact' => 'Contact',
            'testimonials' => 'Testimonials',
            'label' => 'Label',
            'custom' => 'Custom',
            'other' => 'Other',
        ];
    }

    /**
     * Get available languages
     */
    public static function getAvailableLanguages(): array
    {
        return [
            'en' => 'English',
            'de' => 'German',
        ];
    }
}
