<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

/**
 * Installer shell command.
 */
class InstallerShell extends Shell
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
    	$conn = ConnectionManager::get('default');

    	$selection = $this->in('Set up triggers?', ['Y', 'N'], 'Y');

    	if ( $selection == 'Y' || $selection == 'y' ) {
    		$this->out('Setting up triggers');

    		$tiggersql1 = <<<OUT
CREATE TRIGGER `compute_work_ins` BEFORE INSERT ON `payrolls`
 FOR EACH ROW SET NEW.worked = time_to_sec(timediff(NEW.end_time, NEW.start_time))/(60*60)
;
OUT;
			$tiggersql2 = <<<OUT
CREATE TRIGGER `compute_work_upd` BEFORE UPDATE ON `payrolls`
 FOR EACH ROW SET NEW.worked = time_to_sec(timediff(NEW.end_time, NEW.start_time))/(60*60)
;
OUT;
			$conn->execute("DROP TRIGGER IF EXISTS `compute_work_upd`");
			$conn->execute("DROP TRIGGER IF EXISTS `compute_work_ins`");
			$conn->execute($tiggersql1);
			$conn->execute($tiggersql2);

			$this->out('Done.');
		} else {
			$this->out('Skipping...');
		}

		$selection = $this->in('Add admin@tdtrac.com::password?', ['Y', 'N'], 'Y');

		if ( $selection == 'Y' || $selection == 'y' ) {
			$this->out('Adding user');
			$this->loadModel('Users');

			$adminUser = $this->Users->newEntity([
	    		'username' => 'admin@tdtrac.com',
	    		'password' => 'password',
	    		'phone' => 1234567890,
	    		'first' => 'Administrative',
	    		'last' => 'User',
	    		'is_notified' => 1,
	    		'is_admin' => 1,
	    		'time_zone' => 'America/Detroit'
			]);
			if ( $this->Users->save($adminUser) ) {
				$this->out('Create: Admin User #' . $adminUser->id );
				$this->out('Please change the password as soon as possible.');
			} else {
				$this->out('Unable to add - duplicate email probably');
			}
			
		} else {
			$this->out('Skipping...');
		}

		$this->out('Nothing else to do.');
    }
}
