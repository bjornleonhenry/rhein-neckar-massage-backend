<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LanguageKey;
use App\Models\LanguageString;

class HomePageMoreSeeder extends Seeder
{
    public function run()
    {
    $entries = [
            // Services section
            ['key' => 'services.title', 'value_de' => 'Unsere sinnlichen Verführungen', 'value_en' => 'Our Sensual Temptations'],
            ['key' => 'services.description', 'value_de' => 'Entdecken Sie unsere vielfältigen Erotik-Massage Angebote in eleganter, diskreter Verführungsatmosphäre.', 'value_en' => 'Discover our diverse erotic massage offers in an elegant, discreet atmosphere.'],
            ['key' => 'services.cta', 'value_de' => 'Alle Erotik-Preise entdecken', 'value_en' => 'Discover all erotic prices'],
            ['key' => 'services.1.title', 'value_de' => 'Erotische Thai-Massage', 'value_en' => 'Erotic Thai Massage'],
            ['key' => 'services.1.description', 'value_de' => 'Verführerische thailändische Massage mit sinnlichen Techniken zur tiefen Entspannung und erotischen Energiebalance.', 'value_en' => 'Seductive Thai massage with sensual techniques for deep relaxation and erotic energy balance.'],
            ['key' => 'services.1.duration', 'value_de' => '60-90 Min', 'value_en' => '60-90 min'],
            ['key' => 'services.1.price', 'value_de' => 'ab 120€', 'value_en' => 'from €120'],
            ['key' => 'services.2.title', 'value_de' => 'Aphrodisische Öl-Erotik', 'value_en' => 'Aphrodisiac Oil Eroticism'],
            ['key' => 'services.2.description', 'value_de' => 'Leidenschaftliche Ölmassage mit erregenden Aromaölen für ultimative Lust und sinnliches Wohlbefinden.', 'value_en' => 'Passionate oil massage with arousing aroma oils for ultimate pleasure and sensual well-being.'],
            ['key' => 'services.2.duration', 'value_de' => '60-90 Min', 'value_en' => '60-90 min'],
            ['key' => 'services.2.price', 'value_de' => 'ab 150€', 'value_en' => 'from €150'],
            ['key' => 'services.3.title', 'value_de' => 'Wilde Paar-Ekstase', 'value_en' => 'Wild Couple Ecstasy'],
            ['key' => 'services.3.description', 'value_de' => 'Heißes und leidenschaftliches Paar-Erlebnis in unserem privaten Lust-Raum für gemeinsame sinnliche Verführung.', 'value_en' => 'Hot and passionate couple experience in our private pleasure room for shared sensual seduction.'],
            ['key' => 'services.3.duration', 'value_de' => '90-120 Min', 'value_en' => '90-120 min'],
            ['key' => 'services.3.price', 'value_de' => 'ab 300€', 'value_en' => 'from €300'],
            ['key' => 'services.4.title', 'value_de' => 'VIP Lust-Paket', 'value_en' => 'VIP Pleasure Package'],
            ['key' => 'services.4.description', 'value_de' => 'Luxuriöses Erotik-Erlebnis mit verschiedenen Verführungen und exklusivem sinnlichem Service.', 'value_en' => 'Luxurious erotic experience with various seductions and exclusive sensual service.'],
            ['key' => 'services.4.duration', 'value_de' => '120-180 Min', 'value_en' => '120-180 min'],
            ['key' => 'services.4.price', 'value_de' => 'ab 250€', 'value_en' => 'from €250'],

            // Testimonials section
            ['key' => 'testimonials.title', 'value_de' => 'Erotische Erfahrungen unserer Kunden', 'value_en' => 'Erotic Experiences of Our Customers'],
            ['key' => 'testimonials.description', 'value_de' => 'Sie die leidenschaftlichen und sinnlichen Erlebnisse unserer zufriedenen Gentlemen.', 'value_en' => 'See the passionate and sensual experiences of our satisfied gentlemen.'],

            // GirlsProfiles section
            ['key' => 'girls_profiles.title', 'value_de' => 'Unsere Verführerischen Masseurinnen', 'value_en' => 'Our Seductive Masseuses'],
            ['key' => 'girls_profiles.description', 'value_de' => 'Entdecken Sie unsere leidenschaftlichen und sinnlichen Göttinnen der Erotik, die Ihre wildesten Fantasien wahr werden lassen.', 'value_en' => 'Discover our passionate and sensual goddesses of eroticism who make your wildest fantasies come true.'],
            ['key' => 'girls_profiles.cta', 'value_de' => 'Alle Verführerinnen entdecken', 'value_en' => 'Discover all seductresses'],

            // About section (stats)
            ['key' => 'about.stats.1.label', 'value_de' => 'Jahre Erotik-Erfahrung', 'value_en' => 'Years of Erotic Experience'],
            ['key' => 'about.stats.2.label', 'value_de' => 'Orgastische Kunden', 'value_en' => 'Orgasmic Customers'],
            ['key' => 'about.stats.3.label', 'value_de' => 'Lust-Terminbuchung', 'value_en' => 'Pleasure Appointment Booking'],
            ['key' => 'about.stats.4.label', 'value_de' => 'Private Lust-Räume', 'value_en' => 'Private Pleasure Rooms'],

            // AmbientePreview section
            ['key' => 'ambiente.title', 'value_de' => 'Ambiente – VIP Suite', 'value_en' => 'Ambience – VIP Suite'],
            ['key' => 'ambiente.description', 'value_de' => 'Erleben Sie luxuriöse Entspannung in unserer exklusiven VIP Suite mit Whirlpool, Kamin und stilvoller Ausstattung. Perfekt für unvergessliche Momente voller Sinnlichkeit und Komfort.', 'value_en' => 'Experience luxurious relaxation in our exclusive VIP suite with whirlpool, fireplace, and stylish furnishings. Perfect for unforgettable moments full of sensuality and comfort.'],
            ['key' => 'ambiente.feature.1', 'value_de' => 'Whirlpool & Kamin', 'value_en' => 'Whirlpool & Fireplace'],
            ['key' => 'ambiente.feature.2', 'value_de' => 'King-Size Bett & Minibar', 'value_en' => 'King-size bed & minibar'],
            ['key' => 'ambiente.feature.3', 'value_de' => 'Separate Dusche & luxuriöse Ausstattung', 'value_en' => 'Separate shower & luxurious furnishings'],
            ['key' => 'ambiente.cta', 'value_de' => 'Mehr Räume entdecken', 'value_en' => 'Discover more rooms'],

            // Contact section
            ['key' => 'contact.title', 'value_de' => 'Kontakt & Terminbuchung', 'value_en' => 'Contact & Appointment Booking'],
            ['key' => 'contact.description', 'value_de' => 'Vereinbaren Sie noch heute Ihren diskreten Termin für eine exklusive Thai-Massage.', 'value_en' => 'Book your discreet appointment for an exclusive Thai massage today.'],
            ['key' => 'contact.info.title', 'value_de' => 'Kontaktinformationen', 'value_en' => 'Contact Information'],
            ['key' => 'contact.info.address', 'value_de' => 'Adresse', 'value_en' => 'Address'],
            ['key' => 'contact.info.address.value', 'value_de' => 'Elisabethenstraße 45\n64283 Heidenburg', 'value_en' => 'Elisabethenstraße 45\n64283 Heidenburg'],
            ['key' => 'contact.info.phone', 'value_de' => 'Telefon', 'value_en' => 'Phone'],
            ['key' => 'contact.info.phone.value', 'value_de' => '+49 151 00000000', 'value_en' => '+49 151 00000000'],
            ['key' => 'contact.info.email', 'value_de' => 'E-Mail', 'value_en' => 'Email'],
            ['key' => 'contact.info.email.value', 'value_de' => 'paygirls@escortsmassage.com', 'value_en' => 'paygirls@escortsmassage.com'],
            ['key' => 'contact.opening.title', 'value_de' => 'Öffnungszeiten', 'value_en' => 'Opening Hours'],
            ['key' => 'contact.opening.1.day', 'value_de' => 'Montag - Freitag', 'value_en' => 'Monday - Friday'],
            ['key' => 'contact.opening.1.hours', 'value_de' => '12:00 - 24:00', 'value_en' => '12:00 - 24:00'],
            ['key' => 'contact.opening.2.day', 'value_de' => 'Samstag', 'value_en' => 'Saturday'],
            ['key' => 'contact.opening.2.hours', 'value_de' => '14:00 - 02:00', 'value_en' => '14:00 - 02:00'],
            ['key' => 'contact.opening.3.day', 'value_de' => 'Sonntag', 'value_en' => 'Sunday'],
            ['key' => 'contact.opening.3.hours', 'value_de' => '16:00 - 24:00', 'value_en' => '16:00 - 24:00'],
            ['key' => 'contact.form.title', 'value_de' => 'Termin vereinbaren', 'value_en' => 'Book appointment'],
            ['key' => 'contact.form.firstname', 'value_de' => 'Vorname', 'value_en' => 'First name'],
            ['key' => 'contact.form.firstname.placeholder', 'value_de' => 'Ihr Vorname', 'value_en' => 'Your first name'],
            ['key' => 'contact.form.lastname', 'value_de' => 'Nachname', 'value_en' => 'Last name'],
            ['key' => 'contact.form.lastname.placeholder', 'value_de' => 'Ihr Nachname', 'value_en' => 'Your last name'],
            ['key' => 'contact.form.email', 'value_de' => 'E-Mail', 'value_en' => 'Email'],
            ['key' => 'contact.form.email.placeholder', 'value_de' => 'ihre.email@beispiel.de', 'value_en' => 'your.email@example.com'],
            ['key' => 'contact.form.phone', 'value_de' => 'Telefon', 'value_en' => 'Phone'],
            ['key' => 'contact.form.phone.placeholder', 'value_de' => '+49 123 456789', 'value_en' => '+49 123 456789'],
            ['key' => 'contact.form.treatment', 'value_de' => 'Gewünschte Behandlung', 'value_en' => 'Desired treatment'],
            ['key' => 'contact.form.treatment.1', 'value_de' => 'Traditional Thai Massage', 'value_en' => 'Traditional Thai Massage'],
            ['key' => 'contact.form.treatment.2', 'value_de' => 'Oil Massage', 'value_en' => 'Oil Massage'],
            ['key' => 'contact.form.treatment.3', 'value_de' => 'Couple Experience', 'value_en' => 'Couple Experience'],
            ['key' => 'contact.form.treatment.4', 'value_de' => 'VIP Package', 'value_en' => 'VIP Package'],
            ['key' => 'contact.form.message', 'value_de' => 'Nachricht (optional)', 'value_en' => 'Message (optional)'],
            ['key' => 'contact.form.message.placeholder', 'value_de' => 'Ihre Nachricht oder besondere Wünsche...', 'value_en' => 'Your message or special requests...'],
            ['key' => 'contact.form.submit', 'value_de' => 'Termin anfragen', 'value_en' => 'Request appointment'],
            ['key' => 'hero.title', 'value_de' => 'Rhein', 'value_en' => 'Rhein'],
            ['key' => 'hero.title_accent', 'value_de' => 'Neckar', 'value_en' => 'Neckar'],
            ['key' => 'hero.title_tail', 'value_de' => 'Massage Heidelburg', 'value_en' => 'Massage Heidelburg'],
            ['key' => 'hero.cta.book', 'value_de' => 'Termin vereinbaren', 'value_en' => 'Book appointment'],
            ['key' => 'hero.cta.services', 'value_de' => 'Erotik-Services entdecken', 'value_en' => 'Discover erotic services'],
            ['key' => 'hero.feature.technique', 'value_de' => 'Sinnliche Erotik-Techniken', 'value_en' => 'Sensual erotic techniques'],
            ['key' => 'hero.feature.discretion', 'value_de' => 'Verführerische Diskretion', 'value_en' => 'Seductive discretion'],
            ['key' => 'hero.feature.schedule', 'value_de' => 'Flexible Lust-Termine', 'value_en' => 'Flexible pleasure appointments'],

            // New Home page keys
            ['key' => 'home.title', 'value_de' => 'Unsere Verführerischen Masseurinnen', 'value_en' => 'Our Seductive Masseuses'],
            ['key' => 'home.description', 'value_de' => 'Entdecken Sie unsere leidenschaftlichen und sinnlichen Göttinnen der Erotik, die Ihre wildesten Fantasien wahr werden lassen.', 'value_en' => 'Discover our passionate and sensual goddesses of eroticism who make your wildest fantasies come true.'],
            ['key' => 'home.hero.badge', 'value_de' => 'Spitzenmäßig Erotik-Massage Gast Studio in Heidenburg 🇩🇪', 'value_en' => 'Top Erotic Massage Guest Studio in Heidenburg 🇩🇪'],
            ['key' => 'home.hero.intro', 'value_de' => 'Willkommen in unserem exklusiven Erotik-Massage Studio in Heidenburg. Wir bieten Ihnen sinnliche und leidenschaftliche Verführungstechniken in eleganter, diskreter Atmosphäre. Unsere erfahrenen Verführerinnen verwöhnen Sie mit erotischen Behandlungen voller Lust.\n\nJede Behandlung wird individuell auf Ihre verborgensten Wünsche und Sehnsüchte abgestimmt. In unseren privaten, sinnlich eingerichteten Lust-Räumen können Sie vollkommen entspannen und Ihre wildesten Fantasien ausleben. Diskretion und höchste erotische Qualität stehen bei uns im Vordergrund.', 'value_en' => 'Welcome to our exclusive erotic massage studio in Heidenburg. We offer you sensual and passionate seduction techniques in an elegant, discreet atmosphere. Our experienced seductresses pamper you with erotic treatments full of pleasure.\n\nEach treatment is individually tailored to your deepest wishes and desires. In our private, sensually furnished pleasure rooms, you can completely relax and live out your wildest fantasies. Discretion and the highest erotic quality are our top priorities.'],
        ];

        foreach ($entries as $entry) {
            $key = LanguageKey::firstOrCreate(
                ['key' => $entry['key']],
                ['type' => 'page', 'is_active' => true]
            );

            LanguageString::updateOrCreate(
                ['language_key_id' => $key->id, 'lang' => 'de'],
                ['string' => $entry['key'], 'value' => $entry['value_de'], 'is_active' => true]
            );

            LanguageString::firstOrCreate(
                ['language_key_id' => $key->id, 'lang' => 'en'],
                ['string' => $entry['key'], 'value' => $entry['value_en'], 'is_active' => false]
            );
        }
    }
}
