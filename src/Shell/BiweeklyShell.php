<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Network\Email\Email;
/**
 * Biweekly shell command.
 */
class BiweeklyShell extends Shell
{

	public function initialize()
    {
        parent::initialize();
        $this->loadModel('Payrolls');
    }
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main($mailto = null) 
    {
    	$unpaid = $this->Payrolls->find()
    		->contain(['Shows', 'Users'])
            ->select([
                'id', 'date_worked', 'start_time', 'end_time', 'worked', 'is_paid', 'notes', 
                'showname' => 'Shows.name',
                'fullname' => 'concat(Users.first, " ", Users.last)',
                'activeshow' => 'Shows.is_active',
                'Shows.end_date'
            ])
            ->where(['is_paid' => 0])
            ->where(['Shows.is_active' => 1])
    		->order(['Users.last' => 'ASC', 'Users.first' => 'ASC', 'Shows.end_date' => 'DESC', 'date_worked' => 'DESC', 'start_time' => 'DESC']);

    	$datatable = [];
    	$lastuser = "";
    	$subtotal = 0;

    	foreach ( $unpaid as $item ) {
    		if ( $item->fullname <> $lastuser ) {
    			if ( $subtotal > 0 ) {
    				$datatable[] = [ $lastuser, '', 'Subtotal', '', '', '', number_format($subtotal,2) ];
    				$subtotal = 0;
    			}
    			$lastuser = $item->fullname;
    			
    		}
    		$subtotal = $subtotal + $item->worked;
    		$datatable[] = [
    			$item->fullname,
    			$item->showname,
    			$item->notes,
    			$item->date_worked->i18nFormat('YYYY-MM-dd', 'UTC'),
    			$item->start_time->i18nFormat('H:mm', 'UTC'),
    			$item->end_time->i18nFormat('H:mm', 'UTC'),
    			number_format($item->worked, 2),
    		];
    	}
    	if ( $subtotal > 0 ) {
    		$datatable[] = [ $lastuser, '', 'Subtotal', '', '', '', number_format($subtotal,2) ];
    	}

    	$headers = ['User Name', 'Show Name', 'Notes', 'Date Worked', 'Start Time', 'End Time', 'Hours Worked'];

    	$email = new Email();
    	$email->transport('default');
        $email->helpers(['Html', 'Gourmet/Email.Email']);
        $email->emailFormat('both');
		$email->to($mailto);
		$email->subject('Unpaid Hours - ' . date('Y-m-d'));
		$email->from('tdtracx@tdtrac.com');
		$email->template('unpaid');
		$email->viewVars(['headers' => $headers, 'tabledata' => $datatable]);
		$email->send();
    	
    	$this->out('E-Mail Sent.');
    }
}
