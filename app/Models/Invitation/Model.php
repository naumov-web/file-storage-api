<?php

namespace App\Models\Invitation;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\Invitation
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $expired_at
 * @property string $status_id
 * @property string $invitation_code
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'invitations';
}
