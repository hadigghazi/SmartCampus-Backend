<?php
namespace App\Mail;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $announcement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.announcement')
                    ->with([
                        'title' => $this->announcement->title,
                        'content' => $this->announcement->content,
                        'published_date' => $this->announcement->published_date,
                        'visibility' => $this->announcement->visibility,
                        'category' => $this->announcement->category,
                    ]);
    }
}
