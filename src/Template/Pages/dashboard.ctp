<?php if ( count($messagesWaiting) > 0 ) : ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>You have <?= sizeof($messagesWaiting) ?> message(s) waiting.
        <div class="btn-group"><?php
            echo $this->Form->postLink(
                 $this->Pretty->iconDelete("Clear All Messages"),
                 ['controller' => 'messages', 'action' => 'clear', $user->id],
                 ['escape' => false, 'confirm' => __('Are you sure you want to clear all your messages?'), 'class' => 'btn btn-danger btn-sm']
            );
        ?></div></h4>
    </div>
    <table class="table table-bordered">
        <?php foreach ($messagesWaiting as $message) : ?>
            <tr><td><?= $message['note'] ?> <small>on <?= $message['created_at']->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT], 'UTC') ?></small></td><td style="text-align:center"><?php
                echo $this->Form->postLink(
                 $this->Pretty->iconMark("Delete Message #" . $message['id']),
                 ['controller' => 'messages', 'action' => 'delete', $message['id']],
                 ['escape' => false, 'confirm' => __('Are you sure you want to delete this message?'), 'class' => 'btn btn-warning btn-sm']
            );
            ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>

<?php if ($WhoAmI): ?>
<div class="row">
<div class="col-lg-8">
<?php endif; ?>

<div class="row">
    <?php if ( $tasksAdm->count() > 0 || $tasksUser->count() > 0 || $calUser->count() > 0 ) : ?>
    <div class="col-md-6">
        <div class="panel panel-purple">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-calendar fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Tasks &amp; Calendars") ?></div>
                        <div><?= __("A listing of active system shows that you have task list or calendar access to.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/tasks/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View Task Lists</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <a href="/calendars/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View Calendars</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <div class="panel-footer text-center">
                <strong><?= __("Your Task Administrated Shows<br />(Overdue / New / Pending / Total) "); ?></strong>
            </div>

            <?php foreach ( $tasksAdm as $item ): ?>
            <a href="/tasks/view/<?= $item->id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->name ?></span>
                    <span class="pull-right">
                        <span class="badge"><?= $showtask['overdue'][$item->id] ?> / <?= $showtask['new'][$item->id] ?> / <?= $showtask['accept_notdone'][$item->id] ?> / <?= $showtask['total'][$item->id] ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>

            <div class="panel-footer text-center">
                <strong><?= __("Your Task Shows (Your Created Tasks)"); ?></strong>
            </div>

            <?php foreach ( $tasksUser as $item ): ?>
            <a href="/tasks/view/<?= $item->id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->name ?></span>
                    <span class="pull-right">
                        <span class="badge"><?= $showtask['yours'][$item->id] ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>

            <div class="panel-footer text-center">
                <strong><?= __("Your Calendars (Events Today)"); ?></strong>
            </div>

            <?php foreach ( $calUser as $item ): ?>
            <a href="/calendars/view/<?= $item->id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->name ?></span>
                    <span class="pull-right">
                        <span class="badge"><?= $showcal['today'][$item->id] ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ( $budgetAdmin->count() > 0 ) : ?>
    <div class="col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bar-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Budget") ?></div>
                        <div><?= __("A listing of active system shows that you have budget access to.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/budgets/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View Show List</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <div class="panel-footer text-center">
                <strong><?= __("Your Shows"); ?></strong>
            </div>

            <?php foreach ( $budgetAdmin as $item ): ?>
            <a href="/budgets/view/<?= $item->show_id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->showName ?></span>
                    <span class="pull-right">
                        <span class="badge"><?= $this->Number->currency($item->priceTotal); ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
<!-- </div>
<div class="row"> -->
    <?php if ( $payrollSelfShows->count() > 0 || $payrollAdmShows->count() > 0 ) : ?>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-line-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Payroll Shows") ?></div>
                        <div><?= __("A listing of active system shows that you have payroll access to.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/payrolls/">
                <div class="panel-footer"><strong>
                    <span class="pull-left"><?= __("View Show List") ?></span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <div class="panel-footer text-center">
                <strong><?= __("Your Paid Shows"); ?></strong>
            </div>

            <?php foreach ( $payrollSelfShows as $item ): ?>
            <a href="/payrolls/viewbyshow/<?= $item->show_id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->showName ?></span>
                    <span class="pull-right" title="Outstanding Hours">
                        <span class="badge"><?= number_format($item->workTotal,2 ); ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>

            <div class="panel-footer text-center">
                <strong><?= __("Your Administered Shows"); ?></strong>
            </div>

            <?php foreach ( $payrollAdmShows as $item ): ?>
            <a href="/payrolls/viewbyshow/<?= $item->show_id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->showName ?></span>
                    <span class="pull-right" title="Outstanding Hours">
                        <span class="badge"><?= number_format($item->workTotal,2 ); ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>  
        </div>
    </div>
    <?php endif; ?>

    <?php if ( $payrollAdmUsers->count() > 0 ) : ?>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-line-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Payroll Users") ?></div>
                        <div><?= __("A listing of active system users that you have payroll access to.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/payrolls/indexuser">
                <div class="panel-footer"><strong>
                    <span class="pull-left"><?= __("View User List") ?></span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>
            <a href="/payrolls/viewbyuser/<?= $user->id ?>">
                <div class="panel-footer"><strong>
                    <span class="pull-left"><?= __("View Yourself") ?></span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <div class="panel-footer text-center">
                <strong><?= __("Your Administered Users"); ?></strong>
            </div>

            <?php foreach ( $payrollAdmUsers as $item ): ?>
            <?php if ( $item->user_id > 0 ): ?>
            <a href="/payrolls/viewbyuser/<?= $item->user_id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->fullName ?></span>
                    <span class="pull-right" title="Outstanding Hours">
                        <span class="badge"><?= number_format($item->workTotal,2 ); ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    


</div>

<?php if ($WhoAmI): ?>
</div>
<div class="col-lg-4">

        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Users") ?></div>
                        <div><?= __("The system wide user list.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/users/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View User List</span>
                    <span class="pull-right">
                        <span class="badge"><?= $usercnt; ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <a href="/users/add/">
                <div class="panel-footer">
                    <span class="pull-left">Add User</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>

        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Stored Files") ?></div>
                        <div><?= __("The system wide stored files.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/files/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View Files</span>
                    <span class="pull-right">
                        <span class="badge"><?= $files; ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <a href="/files/add/">
                <div class="panel-footer">
                    <span class="pull-left">Add File</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>

        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-clock-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Scheduled Tasks") ?></div>
                        <div><?= __("The system wide scheduled tasks list.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/schedules/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View Scheduled Tasks</span>
                    <span class="pull-right">
                        <span class="badge"><?= $schedules; ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <a href="/schedules/add/">
                <div class="panel-footer">
                    <span class="pull-left">Add Scheduled Task</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>


        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-music fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= __("Shows") ?></div>
                        <div><?= __("The system wide list of active shows, with an overview of permissions for each.") ?></div>
                    </div>
                </div>
            </div>

            <a href="/shows/">
                <div class="panel-footer"><strong>
                    <span class="pull-left">View Show List</span>
                    <span class="pull-right">
                        <span class="badge"><?= $showcnt; ?></span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </strong></div>
            </a>

            <a href="/shows/add/">
                <div class="panel-footer">
                    <span class="pull-left">Add Show</span>
                    <span class="pull-right"><i class="fa fa-lg fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>

            <div class="panel-footer text-center">
                <strong><?= __("Open Shows (Budget/Admin/Paid/TaskUsr/TaskAdm/Cal)"); ?></strong>
            </div>

            <?php foreach ( $shows as $item ): ?>
            <a href="/shows/editperm/<?= $item->id ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?= $item->name ?></span>
                    <span class="pull-right">
                        <span class="badge">
                            <?= 
                                $item->show_user_perms[0]->budgTotal . "/" .
                                $item->show_user_perms[0]->admnTotal . "/" .
                                $item->show_user_perms[0]->paidTotal . "/" .
                                $item->show_user_perms[0]->taskTotal . "/" .
                                $item->show_user_perms[0]->tadmTotal . "/" .
                                $item->show_user_perms[0]->calTotal
                            ?>
                        </span> 
                        <i class="fa fa-lg fa-arrow-right"></i>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

</div>
</div>
<?php endif; ?>

<?= $this->Pretty->helpMeStart(__('Dashboard')); ?>
<p><?= __("This display shows a quick dashboard of your available tasks.") ?></p>
<?= $this->Pretty->helpMeEnd(); ?>
