<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SlipGajiKaryawan extends Mailable
{
    use Queueable, SerializesModels;

    protected $user, $data, $totalGaji, $jumlahKehadiran;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $data, $totalGaji, $jumlahKehadiran)
    {
        $this->user = $user;
        $this->data = $data;
        $this->totalGaji = $totalGaji;
        $this->jumlahKehadiran = $jumlahKehadiran;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Slip Gaji Karyawan {$this->user->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.slip-gaji-karyawan-content',
            with: [
                'user' => $this->user,
                'data' => $this->data,
                'bulan' => date('F', mktime(0, 0, 0, $this->data['bulan'], 10)),
                'totalGaji' => $this->totalGaji,
                'jumlahKehadiran' => $this->jumlahKehadiran,
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
        $pdf = Pdf::loadView('mail.slip-gaji-karyawan-pdf', [
            'user' => $this->user,
            'data' => $this->data,
            'bulan' => date('F', mktime(0, 0, 0, $this->data['bulan'], 10)),
            'totalGaji' => $this->totalGaji,
            'jumlahKehadiran' => $this->jumlahKehadiran,
        ]);
        return [
            Attachment::fromData(fn() => $pdf->output(), "Slip Gaji Karyawan {$this->user->name}.pdf"),
        ];
    }
}
