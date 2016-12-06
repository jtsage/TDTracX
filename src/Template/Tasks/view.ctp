<h3>
    <?= $show->name ?> Tasks
    <div class="btn-group">
        <?php echo $this->Html->link(
            $this->Pretty->iconAdd($show->name . " " . __("Task Item")),
            ['action' => 'add', $show->id],
            ['escape' => false, 'class' => 'btn btn-success btn-sm']
        ); ?>
    </div>

</h3>

<ol class="breadcrumb">
	<li><strong>Sort By: </strong></li>
	<li><a <?= ($sort == "due") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/due">Due Date</a></li>
	<li><a <?= ($sort == "new") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/new">New Items</a></li>
	<li><a <?= ($sort == "created") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/created">Created Date</a></li>
	<li><a <?= ($sort == "updated") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/updated">Updated Date</a></li>
	<li><a <?= ($sort == "priority") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/priority">Assigned Priority</a></li>
</ol>
<table class="table table-striped table-bordered">
        <thead>
            <?= $this->Html->tableHeaders([
                __("Title"),
                __("Category"),
                [__("Priority") => ['class' => 'text-center']],
                __("Due"),
                __("Accepted"),
                __("Complete"),
                [__('Actions') => ['class' => 'text-center']]
            ]); ?>
        </thead>


<?php foreach ($tasks as $task) {

    if ( $task->task_done ) { 
        $done_icon = "check-circle"; $done_clr = "success";
        $cept_icon = "check-circle"; $cept_clr = "success";
    } elseif ( $task->is_overdue ) { 
        $done_icon = "exclamation-circle"; $done_clr = "danger";
        if ( $task->task_accepted ) { 
            $cept_icon = "check-circle"; $cept_clr = "success";        
        } else {
            $cept_icon = "exclamation-circle"; $cept_clr = "danger";
        }
    } elseif ( ! $task->task_accepted ) { 
        $done_icon = "times-circle"; $done_clr = "default";
        $cept_icon = "exclamation-circle"; $cept_clr = "warning";
    } else { 
        $done_icon = "exclamation-circle"; $done_clr = "warning";
        $cept_icon = "check-circle"; $cept_clr = "success";
    }

    $pri_icon = "";
    for ( $i = 1; $i <= $task->priority; $i++ ) {
        $pri_icon .= '<i class="fa fa-bell" aria-hidden="true"></i>';
    }

    echo $this->Html->tableCells([
        [
            $task->title,
            $task->category,
            [
                $pri_icon . " " . ["Missable","Normal","High","Critical"][$task->priority],
                [ 'class' => 'text-center' ]
            ],
            $task->due->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
            [
                '<i class="fa fa-2x fa-' . $cept_icon . '" aria-hidden="true"></i>',
                ['class' => 'text-center text-' . $cept_clr]
            ],
            [
                '<i class="fa fa-2x fa-' . $done_icon . '" aria-hidden="true"></i>',
                ['class' => 'text-center text-' . $done_clr]
            ],
            [
                "<div class='btn-group'>" .
                 $this->Html->link(
                    $this->Pretty->iconView("Detail - " . $task->title),
                    ['action' => 'detail', $task->id],
                    ['escape' => false, 'class' => 'btn btn-primary btn-sm' ] 
                ) .
                ( $opsok ? $this->Html->link(
                    $this->Pretty->iconEdit($task->title),
                    ['action' => 'edit', $task->id],
                    ['escape' => false, 'class' => 'btn btn-default btn-sm' ] 
                ) : "") .
                ( $opsok ? $this->Form->postLink(
                    $this->Pretty->iconDelete($task->title),
                    ['action' => 'delete', $task->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $task->id), 'class' => 'btn btn-danger btn-sm' ] 
                ) : "") . 
                "</div>",
                ['class' => 'text-center']
            ]
        ]
    ]);

} ?>

</table>
<?= $this->Pretty->helpMeStart(__('View Task List by Show')); ?>
<p><?= __("This display allows you to view task items.") ?></p>

<table class="table table-condensed helptable">
<?= $this->Html->tableCells([
    [__("Title"),              __("Title of the task")],
    [__("Due"),                __("Due date of the task.  Defaults to today.")],
    [__("Created By"),         __("User who is responsible for creating this task")],
    [__("Assign To"),          __("User who is responsible for carring out this task")],
    [__("Priority"),           __("Priority of the task.")],
    [__("Category"),           __("A grouping category for this task.")],
    [__("Task Accepted"),      __("The task list administrator has seen and accepted this task")],
    [__("Task Completed"),     __("The task list administrator has marked this task completed")],
    [__("Created / Edited"),   __("The creation and last edit date for this task")],
    [__("Description"),        __("A description of the task.")],
]); ?>
</table>

<?= $this->Pretty->helpMeEnd(); ?>
