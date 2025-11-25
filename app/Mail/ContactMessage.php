<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public array $messageData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $messageData)
    {
        $this->messageData = $messageData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Kontaktanfrage - Rhein Neckar Massage',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: $this->buildHtmlContent(),
        );
    }

    /**
     * Build the HTML content for the email.
     */
    private function buildHtmlContent(): string
    {
        $data = $this->messageData;

        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h1 style='color: #dc2626; border-bottom: 2px solid #dc2626; padding-bottom: 10px;'>Neue Kontaktanfrage</h1>

            <div style='background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Kontaktdaten:</h2>
                <p><strong>Name:</strong> {$data['name']}</p>
                <p><strong>E-Mail:</strong> {$data['email']}</p>
                <p><strong>Telefon:</strong> " . ($data['phone'] ?: 'Nicht angegeben') . "</p>
            </div>

            <div style='background: #f0f9ff; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Anfrage Details:</h2>
                <p><strong>Service:</strong> " . ($data['service'] ?: 'Nicht angegeben') . "</p>
                <p><strong>Gewünschtes Datum:</strong> " . ($data['date'] ?: 'Nicht angegeben') . "</p>
                <p><strong>Gewünschte Uhrzeit:</strong> " . ($data['time'] ?: 'Nicht angegeben') . "</p>
            </div>

            <div style='background: #fff3cd; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Nachricht:</h2>
                <p style='white-space: pre-wrap;'>{$data['message']}</p>
            </div>

            <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;'>
                <p style='color: #666; font-size: 12px;'>
                    Diese E-Mail wurde automatisch von Rhein Neckar Massage generiert.
                </p>
            </div>
        </div>
        ";
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
