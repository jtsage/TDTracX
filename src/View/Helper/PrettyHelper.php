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
    public function iconMark($name)
    {
        return "<span class='sr-only'>" . __('Mark') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Mark') . ": {$name}' class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
    }
    public function iconLock($name)
    {
        return "<span class='sr-only'>" . __('Change Password') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Change Password') . ": {$name}' class='glyphicon glyphicon-lock' aria-hidden='true'></span>";
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
    public function iconDL($name)
    {
        return "<span class='sr-only'>" . __('Download') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('Download') . ": {$name}' class='glyphicon glyphicon-download' aria-hidden='true'></span>";
    }
    public function iconUnpaid($name)
    {
        return "<span class='sr-only'>" . __('View Unpaid') . ": {$name}</span><span style='padding-left: 2px; padding-right: 2px; font-size: 16px' title='" . __('View Unpaid') . ": {$name}' class='glyphicon glyphicon-usd' aria-hidden='true'></span>";
    }

    public function clockPicker( $name, $label, $time=null ) {

        if ( !is_null($time) ) { 
            $realtime = " value=\"" . $time . "\"";
        } else {
            $realtime = "";
        }

        $retty  = '<div class="form-group required">';
        $retty .= '<label class="control-label" for="'. $name . '">' . $label . '</label>';
        $retty .= '<div class="input-group clockpicker">';
        $retty .= '<input type="text" name="' . $name . '" id="' . $name . '" class="form-control"' . $realtime . '>';
        $retty .= '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>';
        $retty .= '</div></div>';
        return $retty;
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
    public function helpMeStart($title = "") {
        $outtie = <<<OUT
<div class="modal fade" id="helpMe" tabindex="-1" role="dialog" aria-labelledby="helpMeLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="helpMeLabel">
OUT;
        $outtie .= $title;
        $outtie .= <<<OUT
</h4>
</div>
<div class="modal-body">
OUT;
        return $outtie;
    }

    public function helpMeEnd() {
        $outtie = <<<OUT
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
OUT;
        return $outtie;
    }
}
?>