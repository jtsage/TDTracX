<div class="budgets form large-10 medium-9 columns">
    <?= $this->Form->create($budget) ?>
    <fieldset>
        <legend><?= __('Add Budget Item') ?></legend>
        <?php
            echo $this->Form->input('show_id', ['options' => $shows]);
            echo $this->Form->input('category', ['autocomplete' => 'off', 'data-provide' => 'typeahead', 'data-source' => $cat]);
            echo $this->Form->input('vendor', ['autocomplete' => 'off', 'data-provide' => 'typeahead', 'data-source' => $vend]);
            echo $this->Form->input('description');
            echo $this->Form->input('price');
            echo $this->Form->input('date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Add Budget Item'); ?>
<p>This display allows you to add a new budget item.</p>
<ul class="list-group">
    <li class="list-group-item"><strong>Show</strong>: locked to the current show.</li>
    <li class="list-group-item"><strong>Category</strong>: A Grouping category for this budget expense.</li>
    <li class="list-group-item"><strong>Vendor</strong>: The Vendor this budget expense was transacted with.</li>
    <li class="list-group-item"><strong>Description</strong>: A description of the expense.</li>
    <li class="list-group-item"><strong>Price</strong>: Price, without dollar sign of the expense.</li>
    <li class="list-group-item"><strong>Date</strong>: Date of the expense.  Defaults to today.</li>
</ul>
<?= $this->Pretty->helpMeEnd(); ?>
