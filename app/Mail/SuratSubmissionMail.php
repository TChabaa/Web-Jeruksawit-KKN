<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuratSubmissionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $surat;
    public $pemohon;
    public $tries = 3;
    public $timeout = 120;
    public $retryUntil;
    public $backoff = [30, 60, 120]; // More conservative retry intervals

    /**
     * Create a new message instance.
     */
    public function __construct($surat, $pemohon)
    {
        $this->surat = $surat;
        $this->pemohon = $pemohon;

        // Set queue configuration
        $this->onQueue('emails');
        $this->retryUntil = now()->addHours(6); // Retry for up to 6 hours

        // Rate limiting - delay between emails to prevent spam
        $this->delay(now()->addSeconds(rand(5, 15)));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pengajuan Surat - ' . $this->surat->jenisSurat->nama_jenis,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.surat-submission',
            with: [
                'surat' => $this->surat,
                'pemohon' => $this->pemohon,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
