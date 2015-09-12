<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShowUserPerm Entity.
 *
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $show_id
 * @property \App\Model\Entity\Show $show
 * @property bool $is_pay_admin
 * @property bool $is_paid
 * @property bool $is_budget
 */
class ShowUserPerm extends Entity
{

}
