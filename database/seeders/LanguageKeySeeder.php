<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Complete snapshot of all language keys (as of September 25, 2025)
        $languageKeys = [
            ['key' => 'button.cancel', 'type' => 'button', 'default' => 'Cancel', 'tags' => '["button", "action"]', 'is_active' => 1],
            ['key' => 'button.delete', 'type' => 'button', 'default' => 'Delete', 'tags' => '["button", "action", "danger"]', 'is_active' => 1],
            ['key' => 'button.edit', 'type' => 'button', 'default' => 'Edit', 'tags' => '["button", "action"]', 'is_active' => 1],
            ['key' => 'button.save', 'type' => 'button', 'default' => 'Save', 'tags' => '["button", "action"]', 'is_active' => 1],
            ['key' => 'error.validation_failed', 'type' => 'text', 'default' => 'Validation failed. Please check your input.', 'tags' => '["error", "validation"]', 'is_active' => 1],
            ['key' => 'footer.address', 'type' => 'text', 'default' => 'WurstStraße 45, 64283 Heidenburg', 'tags' => '["footer"]', 'is_active' => 1],
            ['key' => 'footer.description', 'type' => 'text', 'default' => 'Your exclusive erotic massage studio in Heidenburg. Sensual relaxation in elegant, discreet atmosphere. Highest quality and absolute discretion are our priority.', 'tags' => '["footer"]', 'is_active' => 1],
            ['key' => 'footer.title.line1', 'type' => 'title', 'default' => 'Rhein', 'tags' => '["footer"]', 'is_active' => 1],
            ['key' => 'footer.title.line2', 'type' => 'title', 'default' => 'Neckar', 'tags' => '["footer"]', 'is_active' => 1],
            ['key' => 'footer.title.line3', 'type' => 'title', 'default' => 'Massage', 'tags' => '["footer"]', 'is_active' => 1],
            ['key' => 'hero.cta.book', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.cta.services', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.description', 'type' => 'page', 'default' => NULL, 'tags' => '[]', 'is_active' => 1],
            ['key' => 'hero.feature.discretion', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.feature.schedule', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.feature.technique', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.title', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.title_accent', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'hero.title_tail', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'home.description', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'home.hero.badge', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'home.hero.intro', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'home.title', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'label.email', 'type' => 'text', 'default' => 'Email', 'tags' => '["label", "form"]', 'is_active' => 1],
            ['key' => 'label.name', 'type' => 'text', 'default' => 'Name', 'tags' => '["label", "form"]', 'is_active' => 1],
            ['key' => 'label.password', 'type' => 'text', 'default' => 'Password', 'tags' => '["label", "form"]', 'is_active' => 1],
            ['key' => 'message.error_occurred', 'type' => 'text', 'default' => 'An error occurred. Please try again.', 'tags' => '["error"]', 'is_active' => 1],
            ['key' => 'message.success_saved', 'type' => 'text', 'default' => 'Successfully saved!', 'tags' => '["success"]', 'is_active' => 1],
            ['key' => 'mieterinnen.cta.book', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'mieterinnen.description', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'mieterinnen.title', 'type' => 'page', 'default' => NULL, 'tags' => NULL, 'is_active' => 1],
            ['key' => 'nav.ambiente', 'type' => 'nav', 'default' => 'Ambiance', 'tags' => '["navigation", "menu"]', 'is_active' => 1],
            ['key' => 'nav.angebot', 'type' => 'nav', 'default' => 'Offer', 'tags' => '["navigation", "menu"]', 'is_active' => 1],
            ['key' => 'nav.gaestebuch', 'type' => 'nav', 'default' => 'Guest Book', 'tags' => '["navigation", "menu"]', 'is_active' => 1],
            ['key' => 'nav.home', 'type' => 'nav', 'default' => 'Home', 'tags' => '["navigation", "menu"]', 'is_active' => 1],
            ['key' => 'nav.kontakt', 'type' => 'nav', 'default' => 'Contact', 'tags' => '["navigation", "menu"]', 'is_active' => 1],
            ['key' => 'nav.mieterinnen', 'type' => 'nav', 'default' => 'Tenants', 'tags' => '["navigation", "menu"]', 'is_active' => 1],
            ['key' => 'placeholder.enter_name', 'type' => 'text', 'default' => 'Enter your name', 'tags' => '["form"]', 'is_active' => 1],
            ['key' => 'placeholder.search', 'type' => 'text', 'default' => 'Search...', 'tags' => '["search"]', 'is_active' => 1],
            ['key' => 'success.record_created', 'type' => 'text', 'default' => 'Record created successfully!', 'tags' => '["success", "record"]', 'is_active' => 1],
            ['key' => 'title.dashboard', 'type' => 'title', 'default' => 'Dashboard', 'tags' => '["title", "navigation"]', 'is_active' => 1],
            ['key' => 'title.users', 'type' => 'title', 'default' => 'Users', 'tags' => '["title", "navigation"]', 'is_active' => 1],
            ['key' => 'welcome_message', 'type' => 'text', 'default' => 'Welcome to our application!', 'tags' => '["welcome", "greeting"]', 'is_active' => 1],
            // Angebots page
            ['key' => 'angebot.title', 'type' => 'title', 'default' => 'Our Services', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.description', 'type' => 'text', 'default' => 'Dive into our world of sensual seduction and erotic pleasure. Discover our diverse range of passionate massages and exclusive erotic services. Each treatment is individually tailored to your most hidden desires and longings.', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.button.add_new', 'type' => 'button', 'default' => 'Add New Offer', 'tags' => '["angebot", "button"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.title', 'type' => 'title', 'default' => 'Erotic Additional Services', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.1', 'type' => 'text', 'default' => 'Outcall Erotic Service (Hotel Visits)', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.2', 'type' => 'text', 'default' => 'Overnight Lust Companionship', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.3', 'type' => 'text', 'default' => 'Seductive Dinner Dates', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.4', 'type' => 'text', 'default' => 'Erotic Wellness Packages', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.5', 'type' => 'text', 'default' => 'Lust Gift Vouchers', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.additional_services.6', 'type' => 'text', 'default' => 'Discreet Company Events with Erotica', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.title', 'type' => 'title', 'default' => 'Prices & Booking', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.description', 'type' => 'text', 'default' => 'All prices are base prices for our erotic seductions. Special requests, fetishes and special extras are calculated individually. For personal and discreet advice on your most hidden desires, contact us.', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.deposit.title', 'type' => 'text', 'default' => 'Deposit', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.deposit.description', 'type' => 'text', 'default' => '50% upon booking', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.cancellation.title', 'type' => 'text', 'default' => 'Cancellation', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.cancellation.description', 'type' => 'text', 'default' => 'Free 24h in advance', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.discretion.title', 'type' => 'text', 'default' => 'Discretion', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.pricing.discretion.description', 'type' => 'text', 'default' => '100% guaranteed', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.edit.title', 'type' => 'title', 'default' => 'Edit Offer', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.create.title', 'type' => 'title', 'default' => 'Create New Offer', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.title', 'type' => 'label', 'default' => 'Title', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.category', 'type' => 'label', 'default' => 'Category', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.description', 'type' => 'label', 'default' => 'Description', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.price', 'type' => 'label', 'default' => 'Price (€)', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.duration', 'type' => 'label', 'default' => 'Duration (Minutes)', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.image', 'type' => 'label', 'default' => 'Image URL (optional)', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.active', 'type' => 'label', 'default' => 'Active', 'tags' => '["angebot", "form"]', 'is_active' => 1],
            ['key' => 'angebot.form.services', 'type' => 'label', 'default' => 'Included Services', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.popular', 'type' => 'text', 'default' => 'Popular', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.duration', 'type' => 'text', 'default' => 'Min', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.book_now', 'type' => 'button', 'default' => 'Book Now', 'tags' => '["angebot", "button"]', 'is_active' => 1],
            ['key' => 'angebot.no_services', 'type' => 'text', 'default' => 'No offers available. Add a new offer.', 'tags' => '["angebot", "page"]', 'is_active' => 1],
            ['key' => 'angebot.delete.confirm', 'type' => 'text', 'default' => 'Are you sure you want to delete this offer?', 'tags' => '["angebot", "confirm"]', 'is_active' => 1],
            ['key' => 'angebot.error.save', 'type' => 'error', 'default' => 'Error saving the offer', 'tags' => '["angebot", "error"]', 'is_active' => 1],
            ['key' => 'angebot.error.delete', 'type' => 'error', 'default' => 'Error deleting the offer', 'tags' => '["angebot", "error"]', 'is_active' => 1],
            ['key' => 'angebot.success.save', 'type' => 'success', 'default' => 'Offer saved successfully!', 'tags' => '["angebot", "success"]', 'is_active' => 1],
            ['key' => 'angebot.loading.save', 'type' => 'text', 'default' => 'Saving...', 'tags' => '["angebot", "loading"]', 'is_active' => 1],
            ['key' => 'angebot.error.load', 'type' => 'error', 'default' => 'Error loading offers', 'tags' => '["angebot", "error"]', 'is_active' => 1],
            ['key' => 'angebot.error.save', 'type' => 'error', 'default' => 'Error saving the offer', 'tags' => '["angebot", "error"]', 'is_active' => 1],
            ['key' => 'angebot.error.delete', 'type' => 'error', 'default' => 'Error deleting the offer', 'tags' => '["angebot", "error"]', 'is_active' => 1],
            // Mieterinnen page
            ['key' => 'mieterinnen.specialties.title', 'type' => 'text', 'default' => 'Specialties:', 'tags' => '["mieterinnen", "page"]', 'is_active' => 1],
            ['key' => 'mieterinnen.languages.title', 'type' => 'text', 'default' => 'Languages:', 'tags' => '["mieterinnen", "page"]', 'is_active' => 1],
            ['key' => 'mieterinnen.working_hours.title', 'type' => 'text', 'default' => 'Working Hours:', 'tags' => '["mieterinnen", "page"]', 'is_active' => 1],
        ];

        foreach ($languageKeys as $keyData) {
            DB::table('language_keys')->updateOrInsert(
                ['key' => $keyData['key']],
                array_merge($keyData, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
