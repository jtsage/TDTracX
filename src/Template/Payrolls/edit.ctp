<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payroll->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payroll->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Payrolls'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="payrolls form large-10 medium-9 columns">
    <?= $this->Form->create($payroll) ?>
    <fieldset>
        <legend><?= __('Edit Payroll') ?></legend>
        <?php
            echo $this->Form->input('date_worked');
            echo $this->Form->input('start_time');
            echo $this->Form->input('end_time');
            echo $this->Form->input('is_paid');
            echo $this->Form->input('notes');
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('show_id', ['options' => $shows]);
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
