<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show, ['data-toggle' => 'validator']) ?>
    <fieldset>
        <legend><?= __('Edit Show') ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => __('Name'), 'data-minlength' => 5]);
            echo $this->Form->input('location', ['label' => __('Location'), 'data-minlength' => 5]);
            echo $this->Pretty->datePicker('end_date', __('End Date'),  $show->end_date);
            echo "<label>" . __("Switches") . "</label>";
            echo $this->Pretty->check('is_reminded', $show->is_reminded, [
                'label-width' => '100',
                'label-text' => __('Is Reminded'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'on-color' => 'danger',
                'off-color' => 'success'
            ]);
            echo $this->Pretty->check('is_active', $show->is_active, [
                'label-width' => '100',
                'label-text' => __('Is Active'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'on-color' => 'success',
                'off-color' => 'danger'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart(__('Edit Show')); ?>
<p><?= __("This display allows you to edit an existing show."); ?></p>
<table class="table table-condensed helptable">
<?= $this->Html->tableCells([
    [__("Name"),        __("Name of the show")],
    [__("Location"),    __("Location of the show")],
    [__("End Date"),    __("End date of the show")],
    [__("Is Active"),   __("When checked, budget and payroll items may be added or modified for this show")]
]); ?>
</table>
<?= $this->Pretty->helpMeEnd(); ?>