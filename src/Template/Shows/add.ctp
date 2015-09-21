<div class="shows form large-10 medium-9 columns">
    <?= $this->Form->create($show, ['data-toggle' => 'validator']) ?>
    <fieldset>
        <legend><?= __('Add Show') ?></legend>
        <?php
            echo $this->Form->input('name', ['label' => __('Name'), 'data-minlength' => 5]);
            echo $this->Form->input('location', ['label' => __('Location'), 'data-minlength' => 5]);
            echo $this->Pretty->datePicker('end_date', __('End Date'));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Add'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart(__('Add Show')); ?>
<p><?= __("This display allows you to add a new show."); ?></p>
<table class="table table-condensed helptable">
<?= $this->Html->tableCells([
    [__("Name"),        __("Name of the show")],
    [__("Location"),    __("Location of the show")],
    [__("End Date"),    __("End date of the show")]
]); ?>
</table>
<?= $this->Pretty->helpMeEnd(); ?>
