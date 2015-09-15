<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class UserPermComponent extends Component
{
	/**
     * getAllPerms
     *
     * Grab a simple list of shows that a user is allowed to perfom an action in.
     *
     * @param string|null $id User Id.
     * @param string|null $perm Named permission (is_budget, is_pay_admin, is_paid).
     * @return Array of shows that $id has $perm in.
     */
	public function getAllPerm($id, $perm) {
		$this->ShowUserPerms = TableRegistry::get('ShowUserPerms');

        $perms = $this->ShowUserPerms->find('list', [
            'keyField' => 'id',
            'valueField' => 'show_id',
            'conditions' => ['ShowUserPerms.user_id' => $id, 'ShowUserPerms.' . $perm => 1]
        ]);

        return $perms->toArray();
	}
	/**
     * checkShow
     *
     * Check if a user is allowed to perform an action in the specified show.
     *
     * @param string|null $userId User Id.
     * @param string|null $showId Show Id.
     * @param string|null $perm Named permission (is_budget, is_pay_admin, is_paid).
     * @return Bool $userId is allowed to $perm in $showId.
     */
	public function checkShow($userId, $showId, $perm) {
		$this->ShowUserPerms = TableRegistry::get('ShowUserPerms');
		
		$perms = $this->ShowUserPerms->find()
            ->where(['ShowUserPerms.user_id' => $userId])
            ->where(['ShowUserPerms.show_id' => $showId])
            ->select([
                'user_id' => 'ShowUserPerms.user_id',
                'show_id' => 'ShowUserPerms.show_id',
                'access' => 'ShowUserPerms.' . $perm
                ])
            ->first();

        return $perms->access;
    }
}
?>
