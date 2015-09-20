<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show) ?>
    <fieldset>
        <legend><?= __('Edit Show') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('location');
            echo $this->Form->input('end_date');
            echo "<label>Switches</label>";
            echo $this->Pretty->check('is_active', $show->is_active, [
                'label-width' => '100',
                'label-text' => 'Is Open',
                'on-text' => 'YES',
                'off-text' => 'NO',
                'on-color' => 'success',
                'off-color' => 'danger'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Edit Show'); ?>
<p>This display allows you to edit an existing show.</p>
<ul class="list-group">
    <li class="list-group-item"><strong>Name</strong>: name of the show.</li>
    <li class="list-group-item"><strong>Location</strong>: Location of the show (informational).</li>
    <li class="list-group-item"><strong>End Date</strong>: End date of the show (informational only).</li>
    <li class="list-group-item"><strong>Is Active</strong>: When checked, budget and payroll items may be added or modified for this show.</li>
</ul>
<?= $this->Pretty->helpMeEnd(); ?>