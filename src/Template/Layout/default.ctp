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


if ( $this->request->getParam('controller') == "Pages" ) {
  $cakeDescription = 'TDTracX: the quick time and budget tracking tool for '. CINFO['longname'];
} else {
  $cakeDescription = 'TDTracX:' . CINFO['shortname'] . ":" . $this->fetch('title');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $cakeDescription ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="TDTracX">
    <meta name="application-name" content="TDTracX">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <?php

       echo $this->fetch('meta');
       echo $this->fetch('css');
       echo $this->fetch('script');
      
       echo $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
       echo $this->Html->css('bootstrap-switch.min');
       echo $this->Html->css('https://cdn.jtsage.com/jtsage-datebox/4.4.1/jtsage-datebox-4.4.1.bootstrap4.min.css');
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
  <body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a href="/" class="navbar-brand">TDTrac<span style="color:#C3593C">X</span><span style="color:#c39b1f"><?= CINFO['shortname']?></span></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">

				<li <?= ($this->request->getParam('controller') == "Payrolls" ? "class='active nav-item dropdown'":"class='nav-item dropdown'") ?>>
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= __("Payroll") ?><span class="caret"></span></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/payrolls/"><?= __("By Show") ?></a>
						<a class="dropdown-item" href="/payrolls/indexuser"><?= __("By User") ?></a>
						<?php if ( $WhoAmI ): ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="/payrolls/unpaid/user"><?= __("Unpaid By User") ?></a>
							<a class="dropdown-item" href="/payrolls/unpaid/show"><?= __("Unpaid By Show") ?></a>
						<?php endif; ?>
					</div>
				</li>

				<li class="nav-item <?= ($this->request->getParam('controller') == "Budgets" ? "active'":"") ?>"><a class="nav-link" href="/budgets/"><?= __("Budget") ?></a></li>
				<li class="nav-item <?= ($this->request->getParam('controller') == "Tasks" ? "class='active'":"") ?>"><a class="nav-link" href="/tasks/"><?= __("Tasks") ?></a></li>
				<li class="nav-item <?= ($this->request->getParam('controller') == "Calendars" ? "class='active'":"") ?>"><a class="nav-link" href="/calendars/"><?= __("Calendars") ?></a></li>
				<li class="nav-item <?= ($this->request->getParam('controller') == "Shows" ? "class='active'":"") ?>"><a class="nav-link" href="/shows/"><?= __("Shows") ?></a></li>
				<li class="nav-item <?= ($this->request->getParam('controller') == "Users" ? "class='active'":"") ?>"><a class="nav-link" href="/users/"><?= ($WhoAmI) ? __("Users") : __("My Account") ?></a></li>
				<?= ($WhoAmI) ? "<li class='nav-item" . ($this->request->getParam('controller') == "Schedules" ? " class='active'":"") . "'><a class=\"nav-link\" href=\"/schedules/\">Cron</a></li>" : "" ?>
				<?= ($WhoAmI) ? "<li class='nav-item" . ($this->request->getParam('controller') == "Files" ? " class='active'":"") . "'><a class=\"nav-link\" href=\"/files/\">Files</a></li>" : "" ?>
				<li class="nav-item"><a class="nav-link" href="/users/logout/"><?= __("Logout") ?></a></li>
				<li class="nav-item"><a class="nav-link" onClick="javascript:$('#helpMeModal').modal(); return false;" href="#"><i class="fa fa-lg fa-fw fa-question-circle"></i>&thinsp;<?= __("Help") ?></a></li>
			</ul>
			<?php 
				$user = $this->request->getSession()->read('Auth.User');

				if( ! empty( $user ) ) {
					echo '<p class="navbar-text navbar-right">' . __("Signed in") . ': ' . $user['first'] . " " . $user['last'] . ' </p>';
				}
			?>
		</div>
	</nav>


  <div class="container" style="padding-top:20px" role="main">

    <?php 
      if ( !empty($crumby) && is_array($crumby) ) {
        echo '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        foreach ( $crumby as $crumb ) {
          if ( is_null($crumb[0]) ) {
            echo "<li class='breadcrumb-item active'>" . $crumb[1] . "</li>";
          } else {
            echo "<li class='breadcrumb-item'><a href='" . $crumb[0] . "'>" . $crumb[1] . "</a></li>";
          }
        }
        echo '</ol></nav>';
      }
    ?>

    <?= $this->Flash->render() ?>

    <?= $this->fetch('content') ?>
  
  </div>
  <footer style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e5e5;">
    <p class="text-center text-muted"><?= __("TDTracX: the quick time and budget tracking tool") ?><br /><small>Site Administrator Contact: <a href="mailto:<?= CINFO['adminmail'] ?>"><?= CINFO['adminname'] ?></a></small></p>
    <ul class="text-center list-inline text-muted d-print-none">
    	<li class="list-inline-item"><?= __('Currently v1.4.0a1') ?></li>
    	<li class="list-inline-item"><a href="https://github.com/jtsage/TDTracX">GitHub</a></li>
    	<li class="list-inline-item"><a href="http://tdtrac.com/"><?= __('Home Page') ?></a></li>
    	<li class="list-inline-item"><a href="http://demox.tdtrac.com"><?= __('Demo Application') ?></a></li>
    </ul>
    <p class="text-center text-muted d-print-block d-none">Printed on <?= date('Y-m-d H:i T') ?></p>
  </footer>
  
  <?php
    echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
    echo $this->Html->script('bootstrap3-typeahead.min');
    echo $this->Html->script('bootstrap-switch.min');
    echo $this->Html->script('jquery-ui.min');
    echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js');
    echo $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js');
    echo $this->Html->script('https://cdn.jtsage.com/jtsage-datebox/4.4.1/jtsage-datebox-4.4.1.bootstrap4.min.js');
    echo $this->Html->script('https://tdtrac.com/cdn/external/jquery.mousewheel.min.js');
    echo $this->Html->script('validator.min');
  ?>

  <script type="text/javascript">
    function do_rep() {
      var cur_pass = $('#password').val(),
          cur_user = $('#username').val(),
          cur_text = $('#welcomeEmail').val();

      cur_text = cur_text.replace(/username:.+\n/m, "username: " + cur_user + "\n");
      cur_text = cur_text.replace(/password:.+\n/m, "password: " + cur_pass + "\n");
      $('#welcomeEmail').val(cur_text);
    }
    $('#password').on('change', do_rep);
    $('#username').on('change', do_rep);

    $(".bootcheck").each(function() {
      $(this).bootstrapSwitch();
    });
    $('.toggleState').on('click', function() {
      new_state = ( $(this).attr('id').match(/Off$/) ) ? false : true;

      switch($(this).attr('id')) {
        case 'buserAllOn' :
        case 'buserAllOff':
          selector = "budget"; break;
        case 'paidAllOn' :
        case 'paidAllOff':
          selector = "paid"; break;
        case 'padminAllOn' :
        case 'padminAllOff':
          selector = "padmin"; break;
        case 'tadmAllOn' :
        case 'tadmAllOff':
          selector = "task_admin"; break;
        case 'taskAllOn' :
        case 'taskAllOff':
          selector = "task_user"; break;
        case 'calAllOn' :
        case 'calAllOff':
          selector = "cal"; break;
      }
      $('input[type="checkbox"][name^="'+ selector +'"').bootstrapSwitch('state', new_state);
      return false;
    });
    $('input[type="text"]').each(function() {
      $(this).after($('<div class="help-block with-errors"></div>'));
    })
    $(function () {
      $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
      });
    });
    $('.mark-paid-btn').on('click', function(e){
      e.preventDefault();

      var self = this,
        tdbox = $(this).parent();
        itemnum = $(this).data('item');

      $(self).hide();
      tdbox.addClass('danger');

      cont = confirm('Are you sure you wish to mark item #' + $(this).data('item') + " paid?" );

      if ( cont ) {
        $.ajax({
          url: "/payrolls/markpaidajax/" + itemnum,
          success: function(data) {
            jdata = JSON.parse(data);
            if ( jdata.success == true ) {
              tdbox.removeClass('danger').addClass('success');
              tdbox.find('span').html("yes");
            } else {
              tdbox.removeClass('danger');
              $(self).show();
              alert(jdata.responseString);
            }
          }
        });
      } else {
        $(self).show();
        tdbox.removeClass('danger');
      }

      return false;
    });
    $('#daterangepick #set_dates').on('click', function(e){
      e.preventDefault();
      newhref = window.location.protocol + "//" + window.location.host + window.location.pathname + "/" + $('#start_date').val() + "/" + $('#end_date').val();
      window.location.href = newhref;
    });
  </script>
  </body>
</html>
