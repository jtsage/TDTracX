<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show) ?>
    <fieldset>
        <legend><?= __('Edit Show') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('location');
            echo $this->Form->input('end_date');
            echo $this->Form->input('is_active');
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