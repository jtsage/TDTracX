<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Payroll'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="payrolls index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('date_worked') ?></th>
            <th><?= $this->Paginator->sort('start_time') ?></th>
            <th><?= $this->Paginator->sort('end_time') ?></th>
            <th><?= $this->Paginator->sort('is_paid') ?></th>
            <th><?= $this->Paginator->sort('notes') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($payrolls as $payroll): ?>
        <tr>
            <td><?= $this->Number->format($payroll->id) ?></td>
            <td><?= h($payroll->date_worked) ?></td>
            <td><?= h($payroll->start_time) ?></td>
            <td><?= h($payroll->end_time) ?></td>
            <td><?= h($payroll->is_paid) ?></td>
            <td><?= h($payroll->notes) ?></td>
            <td>
                <?= $payroll->has('user') ? $this->Html->link($payroll->user->id, ['controller' => 'Users', 'action' => 'view', $payroll->user->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $payroll->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payroll->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payroll->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payroll->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
