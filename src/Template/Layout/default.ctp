<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'TDTracX: the quick time and budget tracking tool';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->meta('icon') ?>

    <?php
       echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
       echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css');
       echo $this->Html->css('bootstrap-clockpicker.min');
       echo $this->Html->css('bootstrap-switch.min');
       echo $this->Html->css('bootstrap-datetimepicker.min');
       echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
       echo $this->Html->css('tdtracx');
    ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="padding-top:70px">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="/" class="navbar-brand">TDTrac<span style="color:#C3593C">X</span></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li<?= ($this->request->controller == 'Payrolls') ? " class='active'" : "" ?>><a href="/payrolls/">Payroll</a></li>
            <li<?= ($this->request->controller == 'Budgets') ? " class='active'" : "" ?>><a href="/budgets/">Budget</a></li>
            <li<?= ($this->request->controller == 'Shows') ? " class='active'" : "" ?>><a href="/shows/">Shows</a></li>
            <li<?= ($this->request->controller == 'Users') ? " class='active'" : "" ?>><a href="/users/">Account</a></li>
            <li><a href="/users/logout/">Logout</a></li>
            <li><a data-toggle="modal" data-target="#helpMe" href="#"><i class="fa fa-lg fa-fw fa-question-circle"></i>&thinsp;Help</a></li>
          </ul>

        <?php 
        $user = $this->request->session()->read('Auth.User');

        if( ! empty( $user ) ) 
        {
            echo '<p class="navbar-text navbar-right">Signed in: ' . $user['first'] . " " . $user['last'] . ' </p>';
        } ?>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

  <div class="container" role="main">

    <?php 
      if ( !empty($crumby) && is_array($crumby) ) {
        echo '<ol class="breadcrumb">';
        foreach ( $crumby as $crumb ) {
          if ( is_null($crumb[0]) ) {
            echo "<li class='active'>" . $crumb[1] . "</li>";
          } else {
            echo "<li><a href='" . $crumb[0] . "'>" . $crumb[1] . "</a></li>";
          }
        }
        echo '</ol>';
      }
    ?>

    <?= $this->Flash->render() ?>

    <?= $this->fetch('content') ?>
  
  </div>
  <footer style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e5e5;">
    <p class="text-center text-muted">TDTracX: the quick time and budget tracking tool</p>
    <?= $this->Html->nestedList([
        'Currently v0.0.9', ' ',
        '<a href="https://github.com/jtsage/TDTracX">GitHub</a>', ' ',
        '<a href="http://tdtrac.com/">Home Page</a>', ' ',
        '<a href="http://demox.tdtrac.com">Demo Application</a>'
      ], ["class" => "text-center list-inline text-muted"]
    ); ?>
  </footer>
  
  <?php
    echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
    echo $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
    echo $this->Html->script('bootstrap3-typeahead.min');
    echo $this->Html->script('bootstrap-clockpicker.min');
    echo $this->Html->script('bootstrap-switch.min');
    echo $this->Html->script('bootstrap-datetimepicker.min');
    echo $this->Html->script('validator.min');
  ?>

  <script type="text/javascript">
    $('.clockpicker').each(function() { 
      $(this).clockpicker({
        donetext: 'Done',
        twelvehour: false,
        autoclose: true,
        minutestep: 15,
        placement: 'bottom'
      });
    });
    $(".bootcheck").each(function() {
      $(this).bootstrapSwitch();
    });
    $(".datepicker").each(function() {
      $(this).datetimepicker({
        autoclose: true,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        todayBtn: "linked",
        pickerPosition: "bottom-right",
        fontAwesome: true
      });
    });
    $('.toggleState').on('click', function() {
      switch($(this).attr('id')) {
        case 'buserAllOn' :
          $('input[type="checkbox"][name^="budget"').bootstrapSwitch('state', true);
          break;
        case 'buserAllOff':
          $('input[type="checkbox"][name^="budget"').bootstrapSwitch('state', false);
          break;
        case 'paidAllOn' :
          $('input[type="checkbox"][name^="paid"').bootstrapSwitch('state', true);
          break;
        case 'paidAllOff':
          $('input[type="checkbox"][name^="paid"').bootstrapSwitch('state', false);
          break;
        case 'padminAllOn' :
          $('input[type="checkbox"][name^="padmin"').bootstrapSwitch('state', true);
          break;
        case 'padminAllOff':
          $('input[type="checkbox"][name^="padmin"').bootstrapSwitch('state', false);
          break;
      }
      return false;
    });
    $('input[type="text"]').each(function() {
      $(this).after($('<div class="help-block with-errors"></div>'));
    })
    $(function () {
      $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
      });
    })
  </script>
  </body>
</html>