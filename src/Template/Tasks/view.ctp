<h3><?= $show->name ?> Tasks</h3>

<ol class="breadcrumb">
	<li><strong>Sort By: </strong></li>
	<li><a <?= ($sort == "due") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/due">Due Date</a></li>
	<li><a <?= ($sort == "new") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/new">New Items</a></li>
	<li><a <?= ($sort == "created") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/created">Created Date</a></li>
	<li><a <?= ($sort == "updated") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/updated">Updated Date</a></li>
	<li><a <?= ($sort == "priority") ? 'class="text-success"' : '' ?> href="/tasks/view/<?= $show->id; ?>/priority">Assigned Priority</a></li>
</ol>

<?php foreach ($tasks as $task) : ?>

<?php 
if ( $task->task_done ) { $panel_class = "panel-success"; }
elseif ( $task->is_overdue ) { $panel_class = "panel-danger"; }
elseif ( ! $task->task_accepted ) { $panel_class = "panel-info"; }
elseif ( $task->task_accepted ) { $panel_class = "panel-warning"; }
else { $panel_class = "panel-danger" ;}
?>

<div class="panel <?= $panel_class ?>">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-3">
				<i class="fa fa-tasks fa-5x"></i>
			</div>
			<div class="col-xs-9 text-right">
				<div class="huge"><?php
    				for ( $i = 1; $i <= $task->priority; $i++ ) {
    					echo '<i class="fa fa-bell" aria-hidden="true"></i>';
    				} echo " " . $task->title ?></div>
				<div><?= __("{3}due on {0}{2}{1}", [
					"<strong>",
					"</strong>",
					$task->due->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'),
					(($task->is_overdue) ? "was " : "is ")
				]); ?></div>
			</div>
		</div>
	</div>
	<table class="table table-bordered">
    	<tr><th>Created By</th><td><?= h($task->created_name) ?></td></tr>
    	<tr><th>Asssigned To</th><td><?= h($task->assigned_name) ?></td></tr>
    	<tr><th>Priority</th><td>
    	<?php 
    		for ( $i = 1; $i <= $task->priority; $i++ ) {
    			echo '<i class="fa fa-bell" aria-hidden="true"></i>';
    		}
    		switch ( $task->priority ) {
    			case 0:
    				echo "Missable"; break;
    			case 1:
    				echo " Normal"; break;
    			case 2:
    				echo " High"; break;
    			case 3:
    				echo " Critical"; break;
    		}
    	?></td></tr>
    	<tr><th>Category</th><td><?= h($task->category) ?></td></tr>
    	<tr><th>Task Accepted</th><td class="<?= ($task->task_accepted) ? "success" : "warning" ?>"><?= ($task->task_accepted) ? "yes" : "no" ?></td></tr>
    	<tr><th>Task Complete</th><td class="<?= ($task->task_done) ? "success" : ($task->is_overdue ? "danger" : "warning") ?>"><?= ($task->task_done) ? "YES" : "no" ?></td></tr>
    	<tr><th>Created / Edited</th><td><?= h($task->created_at) ?> &nbsp;/ &nbsp;<?= h($task->updated_at) ?></td></tr>
    	<tr><th colspan="2">Description</th></tr>
  	</table>
	<div class="panel-body">
		<?= $this->Text->autoParagraph(h($task->note)); ?>
	</div>

	<a href="/tasks/edit/<?= $task->id; ?>">
		<div class="panel-footer">
			<span class="pull-left"><?= __('Edit Task Item'); ?></span>
			<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
			<div class="clearfix"></div>
		</div>
	</a>
</div>

<?php endforeach; ?>

<?= $this->Pretty->helpMeStart(__('View Task List by Show')); ?>
<p><?= __("This display allows you to add a view task items.") ?></p>

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
