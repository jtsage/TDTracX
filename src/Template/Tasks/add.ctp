<div class="tasks form large-10 medium-9 columns">
    <?= $this->Form->create($task, ['data-toggle' => 'validator']) ?>
    <fieldset>
        <legend><?= __('Add Task Item') ?></legend>
        <?php
            echo $this->Form->input('show_id', ['label' => __('Show'), 'options' => $shows]);
            echo $this->Form->input('assigned_to', ['label' => __('Assign To'), 'options' => $assignee]);
            echo $this->Form->input('priority', ['label' => __('Priority'), 'options' => [0 => 'Missable', 1 => 'Normal', 2 => 'High', 3 => 'Critical' ]]);
            echo $this->Pretty->datePicker('due', __('Due / Event / Opening Date'));
            echo $this->Form->input('category', ['label' => __('Task Category'), 'autocomplete' => 'off', 'data-provide' => 'typeahead', 'data-source' => $cat]);
            echo $this->Form->input('note');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart(__('Add Budget Item')); ?>
<p><?= __("This display allows you to add a new budget item.") ?></p>

<table class="table table-condensed helptable">
<?= $this->Html->tableCells([
    [__("Show"),               __("locked to the current show.")],
    [__("Budget Category"),    __("A grouping category for this budget expense.")],
    [__("Store or Vendor"),    __("The Vendor this budget expense was transacted with.")],
    [__("Description"),        __("A description of the expense.")],
    [__("Price"),              __("Price, without dollar sign of the expense.")],
    [__("Date"),               __("Date of the expense.  Defaults to today.")]
]); ?>
</table>

<?= $this->Pretty->helpMeEnd(); ?>