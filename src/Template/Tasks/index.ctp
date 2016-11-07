<h3><?= __("Task Lists - Administrator"); ?></h3>

<div class="row">
<?php $rowcount = 0; ?>

<?php foreach ($showsA as $show): ?>
<?php if ( $rowcount == 2 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
<div class="col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-bar-chart fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?= $show->name ?></div>
                    <div><?= __("taking place at {0}{2}{1} and ending on {0}{3}{1}, with a current total of {0}{4}{1} task(s), ", [
                        "<strong>",
                        "</strong>",
                        $show->location,
                        $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
                        $showtask['total'][$show->id]
                    ]); ?><?= __("with {0}{2}{1} pending and {0}{3}{1} done.", [
                        "<strong>",
                        "</strong>",
                        $showtask['done'][$show->id],
                        $showtask['accept_notdone'][$show->id]
                    ]); ?><?=  ($showtask['overdue'][$show->id] > 0 ) ? " There are <strong>{$showtask['overdue'][$show->id]}</strong> overdue task(s)." : ""
                    ?></div>
                </div>
            </div>
        </div>
        <a href="/tasks/add/<?= $show->id; ?>">
            <div class="panel-footer">
                <span class="pull-left"><?= __('Add Task Item'); ?></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
        <a href="/tasks/view/<?= $show->id; ?>">
            <div class="panel-footer">
                <span class="pull-left"><?= __('View and Review Tasks'); ?></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<?php endforeach; ?>
</div>

<h3><?= __("Task Lists - User"); ?></h3>

<div class="row">
<?php $rowcount = 0; ?>

<?php foreach ($showsU as $show): ?>
<?php if ( $rowcount == 2 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-bar-chart fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?= $show->name ?></div>
                    <div><?= __("taking place at {0}{2}{1} and ending on {0}{3}{1}, with a current total of {0}{4}{1} tasks, ", [
                        "<strong>",
                        "</strong>",
                        $show->location,
                        $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
                        $showtask['total'][$show->id]
                    ]); ?><?= __("with {0}{2}{1} pending and {0}{3}{1} done.", [
                        "<strong>",
                        "</strong>",
                        $showtask['done'][$show->id],
                        $showtask['accept_notdone'][$show->id]
                    ]); ?></div>
                </div>
            </div>
        </div>
        <a href="/tasks/add/<?= $show->id; ?>">
            <div class="panel-footer">
                <span class="pull-left"><?= __('Add Task Item'); ?></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
        <a href="/tasks/view/<?= $show->id; ?>">
            <div class="panel-footer">
                <span class="pull-left"><?= __('View and Review Your Tasks'); ?></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<?php endforeach; ?>
</div>

<?php
    // Admin Only, show inactive //
    if ( isset($inactshows) && !empty($inactshows)) { 
        echo "<h3>" . __("Closed Task Lists") . "</h3>";
    }
?>

<div class="row">
<?php $rowcount = 0; ?>

<?php foreach ($showsA as $show): ?>
<?php if ( $rowcount == 2 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
<div class="col-md-6">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-bar-chart fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge"><?= $show->name ?></div>
                    <div><?= __("taking place at {0}{2}{1} and ending on {0}{3}{1}, with a current total of {0}{4}{1} tasks, ", [
                        "<strong>",
                        "</strong>",
                        $show->location,
                        $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
                        $showtask['total'][$show->id]
                    ]); ?><?= __("with {0}{2}{1} pending and {0}{3}{1} done.", [
                        "<strong>",
                        "</strong>",
                        $showtask['done'][$show->id],
                        $showtask['accept_notdone'][$show->id]
                    ]); ?></div>
                </div>
            </div>
        </div>
        <a href="/tasks/view/<?= $show->id; ?>">
            <div class="panel-footer">
                <span class="pull-left"><?= __('View and Review Tasks'); ?></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<?php endforeach; ?>
</div>



<?= $this->Pretty->helpMeStart(__('View Task Lists')); ?>
<p><?= _("This display shows the tasks of the shows you have access to.") ?></p>
<p><?= _("For shows you administer, you may do anything to the task list.") ?></p>
<p><?= _("For the shows you are a user in, you may edit only your own items and submit new ones") ?></p>
<p><?= _("Additionally, if you are a system administrator, you can view the budgets from closed (inactive) shows.") ?></p>
<?= $this->Pretty->helpMeEnd(); ?>
