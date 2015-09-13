<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Show User Perm'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="showUserPerms index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('user_id') ?></th>
            <th><?= $this->Paginator->sort('show_id') ?></th>
            <th><?= $this->Paginator->sort('is_pay_admin') ?></th>
            <th><?= $this->Paginator->sort('is_paid') ?></th>
            <th><?= $this->Paginator->sort('is_budget') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($showUserPerms as $showUserPerm): ?>
        <tr>
            <td><?= $this->Number->format($showUserPerm->id) ?></td>
            <td>
                <?= $showUserPerm->has('user') ? $this->Html->link($showUserPerm->user->id, ['controller' => 'Users', 'action' => 'view', $showUserPerm->user->id]) : '' ?>
            </td>
            <td>
                <?= $showUserPerm->has('show') ? $this->Html->link($showUserPerm->show->name, ['controller' => 'Shows', 'action' => 'view', $showUserPerm->show->id]) : '' ?>
            </td>
            <td><?= h($showUserPerm->is_pay_admin) ?></td>
            <td><?= h($showUserPerm->is_paid) ?></td>
            <td><?= h($showUserPerm->is_budget) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $showUserPerm->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $showUserPerm->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $showUserPerm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $showUserPerm->id)]) ?>
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
