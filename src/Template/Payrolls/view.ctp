<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Payroll'), ['action' => 'edit', $payroll->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payroll'), ['action' => 'delete', $payroll->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payroll->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payrolls'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payroll'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="payrolls view large-10 medium-9 columns">
    <h2><?= h($payroll->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Notes') ?></h6>
            <p><?= h($payroll->notes) ?></p>
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $payroll->has('user') ? $this->Html->link($payroll->user->id, ['controller' => 'Users', 'action' => 'view', $payroll->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Show') ?></h6>
            <p><?= $payroll->has('show') ? $this->Html->link($payroll->show->name, ['controller' => 'Shows', 'action' => 'view', $payroll->show->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($payroll->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Worked') ?></h6>
            <p><?= h($payroll->date_worked) ?></p>
            <h6 class="subheader"><?= __('Start Time') ?></h6>
            <p><?= h($payroll->start_time) ?></p>
            <h6 class="subheader"><?= __('End Time') ?></h6>
            <p><?= h($payroll->end_time) ?></p>
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($payroll->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($payroll->updated_at) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Is Paid') ?></h6>
            <p><?= $payroll->is_paid ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
