<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $bookingData;

    public function __construct($bookingData)
    {
        $this->bookingData = $bookingData;
    }

    // 1. Tentukan Channel (Database & Mail)
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    // 2. Format untuk Email
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Notifikasi Booking Baru')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Ada booking baru dengan ID: ' . $this->bookingData['id'])
                    ->action('Lihat Booking', url('/bookings/' . $this->bookingData['id']))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    // 3. Format untuk Database (akan ditampilkan di Navbar)
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Booking Baru',
            'message' => 'Booking #'.$this->bookingData['id'].' berhasil dibuat.',
            'url' => url('/bookings/' . $this->bookingData['id']),
            'icon' => 'calendar' // Bisa disesuaikan untuk icon di view
        ];
    }
}
