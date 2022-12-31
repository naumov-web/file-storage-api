<?php

namespace App\Models\Invitation\Emails;

use App\Models\Invitation\DTO\InvitationDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

/**
 * Class InvitationCreated
 * @package App\Models\Invitation\Emails
 */
final class InvitationCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Email subject
     * @var string
     */
    const SUBJECT = 'Invitation to Private File Storage';

    /**
     * InvitationCreated constructor
     * @param InvitationDTO $dto
     */
    public function __construct(private InvitationDTO $dto) {}

    /**
     * Build email content
     *
     * @return Content
     */
    public function content()
    {
        $this->subject(self::SUBJECT);

        return new Content(
            view: 'emails.invitation-created',
            with: [
                'name' => $this->dto->name,
                'password' => $this->dto->password,
                'link' => $this->getLink(),
            ]
        );
    }

    /**
     * Get link for confirmation
     *
     * @return string
     */
    private function getLink(): string
    {
        return route('api.v1.invitations.confirm', ['code' => $this->dto->invitationCode]);
    }
}
