<?php
/* src/View/Helper/PrettyHelper.php (using other helpers) */

namespace App\View\Helper;

use Cake\View\Helper;

class PrettyHelper extends Helper
{

    public function phone($value)
    {
        if ( $value  < 100000000 ) { return "n/a"; }
        return substr($value, 0, 3) . "." . substr($value, 3, 3) . "." . substr($value, 6, 4);
    }
    public function iconEdit($name)
    {
    	return "<span class='sr-only'>" . __('Edit') . " {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Edit') . " {$name}' class='glyphicon glyphicon-pencil' aria-hidden='true'></span>";
    }
    public function iconView($name)
    {
    	return "<span class='sr-only'>" . __('View') . " {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('View') . " {$name}' class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>";
    }
    public function iconDelete($name)
    {
    	return "<span class='sr-only'>" . __('Delete') . " {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Delete') . " {$name}' class='glyphicon glyphicon-trash' aria-hidden='true'></span>";
    }
}
?>