<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuratRejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;
    public $pemohon;
    public $catatan;

    /**
     * Create a new message instance.
     */
    public function __construct($surat, $pemohon, $catatan = null)
    {
        $this->surat = $surat;
        $this->pemohon = $pemohon;
        $this->catatan = $catatan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penolakan Surat - ' . $this->surat->jenisSurat->nama_jenis,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.surat-rejection',
            with: [
                'surat' => $this->surat,
                'pemohon' => $this->pemohon,
                'catatan' => $this->catatan,
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
