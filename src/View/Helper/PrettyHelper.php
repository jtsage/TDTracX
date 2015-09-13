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
    	return "<span class='sr-only'>" . __('Edit') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Edit') . ": {$name}' class='glyphicon glyphicon-pencil' aria-hidden='true'></span>";
    }
    public function iconView($name)
    {
    	return "<span class='sr-only'>" . __('View') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('View') . ": {$name}' class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>";
    }
    public function iconDelete($name)
    {
    	return "<span class='sr-only'>" . __('Delete') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Delete') . ": {$name}' class='glyphicon glyphicon-trash' aria-hidden='true'></span>";
    }
    public function iconAdd($name)
    {
        return "<span class='sr-only'>" . __('Add') . " {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Add') . " {$name}' class='glyphicon glyphicon-plus' aria-hidden='true'></span>";
    }
    public function iconPerm($name)
    {
        return "<span class='sr-only'>" . __('User Permissions') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('User Permissions') . ": {$name}' class='glyphicon glyphicon-user' aria-hidden='true'></span>";
    }

    public function onoff($name, $check=false)
    {
        $outtie  = '<div class="onoffswitch">';
        $outtie .= '<input value="true" type="checkbox" name="' . $name . '" class="onoffswitch-checkbox" id="' . $name . '" ' . ($check?"checked":"") . '>';
        $outtie .= '<label class="onoffswitch-label" for="' . $name . '">';
        $outtie .= '<span class="onoffswitch-inner"></span>';
        $outtie .= '<span class="onoffswitch-switch"></span>';
        $outtie .= '</label></div>';
        return $outtie;
    }
}
?>