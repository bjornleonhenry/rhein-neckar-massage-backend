<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LanguageKey extends Model
{
    protected $fillable = [
        'key',
        'type',
        'default',
        'tags',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tags' => 'array',
    ];

    /**
     * Get the translations for this key
     */
    public function translations(): HasMany
    {
        return $this->hasMany(LanguageString::class, 'language_key_id');
    }

    /**
     * Scope to get only active keys
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope to get keys by type
     */
    public function scopeByType(Builder $query, string $type): void
    {
        $query->where('type', $type);
    }

    /**
     * Scope to get keys with specific tags
     */
    public function scopeWithTags(Builder $query, array $tags): void
    {
        $query->whereJsonContains('tags', $tags);
    }

    /**
     * Get translation value for a specific language
     */
    public function getTranslation(string $lang): ?string
    {
        return $this->translations()
            ->where('lang', $lang)
            ->where('is_active', true)
            ->first()?->value;
    }

    /**
     * Get all translations for this key
     */
    public function getAllTranslations(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->translations()
            ->where('is_active', true)
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
            'page' => 'Page',
            'admin' => 'Admin',
        ];
    }
}
