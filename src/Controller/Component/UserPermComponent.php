<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class UserPermComponent extends Component
{
	public function getAllPerm($id, $perm) {
		$this->ShowUserPerms = TableRegistry::get('ShowUserPerms');

        $perms = $this->ShowUserPerms->find('list', [
            'keyField' => 'id',
            'valueField' => 'show_id',
            'conditions' => ['ShowUserPerms.user_id' => $id, 'ShowUserPerms.' . $perm => 1]
        ]);

        return $perms->toArray();
	}
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
