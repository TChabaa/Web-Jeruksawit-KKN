<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class SuratApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;
    public $pemohon;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($surat, $pemohon, $pdfPath)
    {
        $this->surat = $surat;
        $this->pemohon = $pemohon;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Surat ' . $this->surat->jenisSurat->nama_jenis . ' Telah Disetujui',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.surat-approval',
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
        return [
            Attachment::fromPath($this->pdfPath)
                ->as('surat_' . str_replace(' ', '_', strtolower($this->surat->jenisSurat->nama_jenis)) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
