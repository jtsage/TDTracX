<h3><?= __("Task Lists - Administrator"); ?></h3>

<div class="row">
<?php $rowcount = 0; ?>

<?php foreach ($showsA as $show): ?>
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
                    <div><?= __("taking place at {0}{2}{1} and ending on {0}{3}{1}, with a current total of {0}{4}{1} tasks", [
                        "<strong>",
                        "</strong>",
                        $show->location,
                        $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
                        0 #$this->Number->currency($total)
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
                    <div><?= __("taking place at {0}{2}{1} and ending on {0}{3}{1}, with a current total of {0}{4}{1} tasks", [
                        "<strong>",
                        "</strong>",
                        $show->location,
                        $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
                        0 #$this->Number->currency($total)
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





<?= $this->Pretty->helpMeStart(__('View Show Budgets')); ?>
<p><?= _("This display shows the budgets of the shows you have access, along with the current expenditure broken down by budget category.") ?></p>
<p><?= _("For each show, you have the option of viewing a detailed budget report, or adding a budget item to the report") ?></p>
<p><?= _("Additionally, if you are a system administrator, you can view the budgets from closed (inactive) shows.") ?></p>
<?= $this->Pretty->helpMeEnd(); ?>
