<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $budget->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Budgets'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="budgets form large-10 medium-9 columns">
    <?= $this->Form->create($budget) ?>
    <fieldset>
        <legend><?= __('Edit Budget') ?></legend>
        <?php
            echo $this->Form->input('category');
            echo $this->Form->input('vendor');
            echo $this->Form->input('description');
            echo $this->Form->input('date');
            echo $this->Form->input('price');
            echo $this->Form->input('show_id', ['options' => $shows]);
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
