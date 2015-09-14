<div class="budgets form large-10 medium-9 columns">
    <?= $this->Form->create($budget) ?>
    <fieldset>
        <legend><?= __('Edit Budget Item') ?></legend>
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
