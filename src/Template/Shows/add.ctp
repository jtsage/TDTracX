<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show) ?>
    <fieldset>
        <legend><?= __('Add Show') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('location');
            echo $this->Pretty->datePicker('end_date', 'End Date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Add Show'); ?>
<p><?= _("This display allows you to add a new show."); ?></p>
<?= $this->Html->nestedList([
        "<strong>Name</strong>: name of the show.",
        "<strong>Location</strong>: Location of the show (informational).",
        "<strong>End Date</strong>: End date of the show (informational only)."
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<?= $this->Pretty->helpMeEnd(); ?>
