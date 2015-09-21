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
    public function makeIcon($name, $icon, $text) {
        return "<span class='sr-only'>{$text}: {$name}</span><i class='fa fa-lg fa-fw fa-{$icon}' title='{$text}: {$name}'></i></span>";
    }
    public function iconEdit($name)
    {
        return PrettyHelper::makeIcon($name, 'pencil-square-o', __('Edit'));
    }
    public function iconMark($name)
    {
        return PrettyHelper::makeIcon($name, 'check-circle-o', __('Edit'));
    }
    public function iconLock($name)
    {
        return PrettyHelper::makeIcon($name, 'lock', __('CXhange Password'));
    }
    public function iconView($name)
    {
        return PrettyHelper::makeIcon($name, 'eye', __('View'));
    }
    public function iconDelete($name)
    {
        return PrettyHelper::makeIcon($name, 'trash', __('Delete'));
    }
    public function iconAdd($name)
    {
        return PrettyHelper::makeIcon($name, 'plus', __('Add'));
    }
    public function iconPerm($name)
    {
        return PrettyHelper::makeIcon($name, 'cogs', __('User Permissions'));
    }
    public function iconDL($name)
    {
        return PrettyHelper::makeIcon($name, 'cloud-download', __('Download'));
    }
    public function iconUnpaid($name)
    {
        return PrettyHelper::makeIcon($name, 'usd', __('View Unpaid'));
    }
    public function helpButton($icon, $color = 'default', $name, $desc) {
        return '<a href="#" class="btn btn-' . $color . ' btn-sm"><i class="fa fa-fw fa-lg fa-' . $icon . '" aria-hidden="true"></i></a>' .
        ' <strong>' . $name . '</strong>: ' . $desc;
    }
    public function jqButton($icon, $color = 'default', $id, $class="", $title="") {
        return '<a href="#" title="' . $title . '" class="btn btn-' . $color . ' ' . $class . ' btn-sm" id="' . $id . '"><i class="fa fa-fw fa-lg fa-' . $icon . '" aria-hidden="true"></i></a>';
    }

    public function money($name, $label, $value=null) {

        $retty  = '<div class="form-group required">';
        $retty .= '<label class="control-label" for="' . $name . '">' . $label . '</label>';
        $retty .= '<div class="input-group"><span class="input-group-addon">$</span>';
        $retty .= '<input type="number" ' . ((!is_null($value)) ? "value='" . number_format($value,2) . "'" : "" ) . ' name="' . $name . '" required="required" step=".01" min="0" id="price" class="form-control">';
        $retty .= "</div></div>";
        return $retty;
    }
    public function clockPicker( $name, $label, $time=null ) {

        if ( !is_null($time) ) { 
            $realtime = " value=\"" . $time . "\"";
        } else {
            $realtime = "";
        }

        $retty  = '<div class="form-group required">';
        $retty .= '<label class="control-label">' . $label . '</label>';
        $retty .= '<div class="input-group clockpicker">';
        $retty .= '<input type="text" name="' . $name . '" id="' . $name . '" class="form-control"' . $realtime . '>';
        $retty .= '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>';
        $retty .= '</div></div>';
        return $retty;
    }

    public function datePicker( $name, $label, $time=null ) {

        
        if ( !is_null($time) ) { 
            $realtime = $time->i18nFormat('YYYY-MM-dd') . "T00:00:00Z";
            $val = $time->i18nFormat('YYYY-MM-dd');
            $pretval = $time->i18nFormat('MMMM d, YYYY');
        } else {
            $realtime = date('Y-m-d') . "T00:00:00Z";
            $val = date('Y-m-d');
            $pretval = date('F d, Y');
        }

        $retty  = '<div class="form-group">';
        $retty .= '<label class="control-label">' . $label . '</label>';
        $retty .= '<div class="input-group date datepicker" data-date="' . $realtime . '" data-date-format="MM d, yyyy" data-link-field="' . $name . '" data-link-format="yyyy-mm-dd">';
        $retty .= '<input class="form-control" size="16" type="text" value="' . $pretval . '" readonly>';
        $retty .= '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';
        $retty .= '</div><input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /><br/></div>';

        return $retty;
    }

    public function check($name, $check=false, $other=null, $size="normal") {
        $outtie  = '<div class="form-group">';
        $outtie .= '<input type="hidden" name="' . $name . '" value="0">';
        $outtie .= '<input type="checkbox" name="' . $name . '" ';
        $outtie .= 'class="bootcheck" data-size="' . $size . '" ';
        $outtie .= "value='1' ";
        $outtie .= ($check) ? "checked " : "";
        if ( is_array($other) ) {
            foreach ( $other as $key => $value ) {
                $outtie .= "data-" . $key . '="' . $value . '" ';
            }
        }
        $outtie .= '></div>';
        return $outtie;

    }
    public function helpMeStart($title = "") {
        $outtie = '<div class="modal fade" id="helpMe" tabindex="-1" role="dialog" aria-labelledby="helpMeLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="helpMeLabel">';
        $outtie .= $title;
        return $outtie . '</h4></div><div class="modal-body">';
    }

    public function helpMeEnd() {
        return '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
    }
}
?>