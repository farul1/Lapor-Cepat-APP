<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengaduan;

class LaporanStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pengaduan;
    public $newStatus;
    public $tanggapanAdmin;
    public $alasanDitolak;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengaduan $pengaduan, string $newStatus, ?string $tanggapanAdmin = null, ?string $alasanDitolak = null)
    {
        $this->pengaduan = $pengaduan;
        $this->newStatus = $newStatus;
        $this->tanggapanAdmin = $tanggapanAdmin;
        $this->alasanDitolak = $alasanDitolak;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = '';
        if ($this->newStatus == 'diterima') {
            $subject = 'Pembaruan Laporan: Laporan Anda Telah Diterima';
        } elseif ($this->newStatus == 'diproses') {
            $subject = 'Pembaruan Laporan: Laporan Anda Sedang Diproses';
        } elseif ($this->newStatus == 'selesai') {
            $subject = 'Pembaruan Laporan: Laporan Anda Telah Selesai Ditindaklanjuti';
        } elseif ($this->newStatus == 'ditolak') {
            $subject = 'Pembaruan Laporan: Laporan Anda Ditolak';
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.laporan-status-updated', // Akan kita buat file blade ini
            with: [
                'pengaduan' => $this->pengaduan,
                'newStatus' => $this->newStatus,
                'tanggapanAdmin' => $this->tanggapanAdmin,
                'alasanDitolak' => $this->alasanDitolak,
            ],
        );
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
