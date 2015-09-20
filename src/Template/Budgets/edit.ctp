<div class="budgets form large-10 medium-9 columns">
    <?= $this->Form->create($budget) ?>
    <fieldset>
        <legend><?= __('Edit Budget Item') ?></legend>
        <?php
            echo $this->Form->input('show_id', ['options' => $shows]);
            echo $this->Form->input('category', ['autocomplete' => 'off', 'data-provide' => 'typeahead', 'data-source' => $cat]);
            echo $this->Form->input('vendor', ['autocomplete' => 'off', 'data-provide' => 'typeahead', 'data-source' => $vend]);
            echo $this->Form->input('description');
            echo $this->Pretty->money('price', 'Price', $budget->price);
            echo $this->Pretty->datePicker('date', 'Date', $budget->date);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Edit Budget Item'); ?>
<p><?= _("This display allows you to edit and existing budget item.") ?></p>
<?= $this->Html->nestedList([
        "<strong>Show</strong>: locked to the current show.",
        "<strong>Category</strong>: A Grouping category for this budget expense.",
        "<strong>Vendor</strong>: The Vendor this budget expense was transacted with.",
        "<strong>Description</strong>: A description of the expense.",
        "<strong>Price</strong>: Price, without dollar sign of the expense.",
        "<strong>Date</strong>: Date of the expense.  Defaults to today."
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<?= $this->Pretty->helpMeEnd(); ?>