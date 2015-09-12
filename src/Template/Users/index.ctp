
<!-- 
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payrolls'), ['controller' => 'Payrolls', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payroll'), ['controller' => 'Payrolls', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Show User Perms'), ['controller' => 'ShowUserPerms', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Show User Perm'), ['controller' => 'ShowUserPerms', 'action' => 'add']) ?></li>
    </ul>
</div> -->
<div class="users index large-10 medium-9 columns">
    <table class="table table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('username', __("E-Mail")) ?></th>
            <th><?= $this->Paginator->sort('first', __("First Name")) ?></th>
            <th><?= $this->Paginator->sort('last', __("Last Name")) ?></th>
            <th><?= $this->Paginator->sort('phone') ?></th>
            <th><?= $this->Paginator->sort('is_active', __("Active User")) ?></th>
            <th><?= $this->Paginator->sort('is_admin', __("Administrator")) ?></th>
            <th><?= $this->Paginator->sort('last_login_at', __("Last Login")) ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= h($user->username) ?></td>
            <td><?= h($user->first) ?></td>
            <td><?= h($user->last) ?></td>
            <td><?= $this->Pretty->phone($user->phone) ?></td>
            <td><?= $this->Bool->prefYes($user->is_active) ?></td>
            <td><?= $this->Bool->prefNo($user->is_admin) ?></td>
            <td><?= $user->last_login_at->i18nFormat(null, $tz); ?></td>
            <td class="actions">
                <?= $this->Html->link(
                    $this->Pretty->iconView($user->username),
                    ['action' => 'view', $user->id],
                    ['escape' => false]
                ) ?>
                <?= $this->Html->link(
                    $this->Pretty->iconEdit($user->username),
                    ['action' => 'edit', $user->id],
                    ['escape' => false]
                ) ?>
                <?= $this->Form->postLink(
                    $this->Pretty->iconDelete($user->username),
                    ['action' => 'delete', $user->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
                ) ?>
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
