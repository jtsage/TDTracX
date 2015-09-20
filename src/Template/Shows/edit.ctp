<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show) ?>
    <fieldset>
        <legend><?= __('Edit Show') ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => __('Name')]);
            echo $this->Form->input('location', ['label' => __('Location')]);
            echo $this->Pretty->datePicker('end_date', __('End Date'),  $show->end_date);
            echo "<label>Switches</label>";
            echo $this->Pretty->check('is_active', $show->is_active, [
                'label-width' => '100',
                'label-text' => __('Is Open'),
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
<?= $this->Html->nestedList([
        "<strong>Name</strong>: name of the show.",
        "<strong>Location</strong>: Location of the show (informational).",
        "<strong>End Date</strong>: End date of the show (informational only).",
        "<strong>Is Active</strong>: When checked, budget and payroll items may be added or modified for this show."
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<?= $this->Pretty->helpMeEnd(); ?>