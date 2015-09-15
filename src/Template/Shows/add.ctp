<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show) ?>
    <fieldset>
        <legend><?= __('Add Show') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('location');
            echo $this->Form->input('end_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Add Show'); ?>
<p>This display allows you to add a new show.</p>
<ul class="list-group">
    <li class="list-group-item"><strong>Name</strong>: name of the show.</li>
    <li class="list-group-item"><strong>Location</strong>: Location of the show (informational).</li>
    <li class="list-group-item"><strong>End Date</strong>: End date of the show (informational only).</li>
</ul>
<?= $this->Pretty->helpMeEnd(); ?>
