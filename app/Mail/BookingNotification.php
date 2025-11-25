<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public array $bookingData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $bookingData)
    {
        $this->bookingData = $bookingData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Buchungsanfrage - Rhein Neckar Massage',
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
        $data = $this->bookingData;

        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h1 style='color: #dc2626; border-bottom: 2px solid #dc2626; padding-bottom: 10px;'>Neue Buchungsanfrage</h1>

            <div style='background: #f9f9f9; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Kundendaten:</h2>
                <p><strong>Name:</strong> {$data['name']}</p>
                <p><strong>E-Mail:</strong> {$data['email']}</p>
                <p><strong>Telefon:</strong> {$data['phone']}</p>
            </div>

            <div style='background: #f0f9ff; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Buchungsdetails:</h2>
                <p><strong>Masseurin:</strong> " . ($data['girl'] ?: 'Nicht angegeben') . "</p>
                <p><strong>Service:</strong> {$data['service']}</p>
                <p><strong>Datum:</strong> {$data['date']}</p>
                <p><strong>Uhrzeit:</strong> {$data['time']}</p>
                <p><strong>Dauer:</strong> {$data['duration']}</p>
            </div>

            " . (!empty($data['message']) ? "
            <div style='background: #fff3cd; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Nachricht:</h2>
                <p style='white-space: pre-wrap;'>{$data['message']}</p>
            </div>
            " : "") . "

            " . (!empty($data['specialRequests']) ? "
            <div style='background: #f8d7da; padding: 20px; margin: 20px 0; border-radius: 8px;'>
                <h2 style='color: #333; margin-top: 0;'>Spezielle Wünsche:</h2>
                <p style='white-space: pre-wrap;'>{$data['specialRequests']}</p>
            </div>
            " : "") . "

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
