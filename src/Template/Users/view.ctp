<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payrolls'), ['controller' => 'Payrolls', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payroll'), ['controller' => 'Payrolls', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Show User Perms'), ['controller' => 'ShowUserPerms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show User Perm'), ['controller' => 'ShowUserPerms', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="users view large-10 medium-9 columns">
    <h2><?= h($user->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Username') ?></h6>
            <p><?= h($user->username) ?></p>
            <h6 class="subheader"><?= __('First') ?></h6>
            <p><?= h($user->first) ?></p>
            <h6 class="subheader"><?= __('Last') ?></h6>
            <p><?= h($user->last) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($user->id) ?></p>
            <h6 class="subheader"><?= __('Phone') ?></h6>
            <p><?= $this->Pretty->phone($user->phone) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Last Login At') ?></h6>
            <p><?= h($user->last_login_at) ?></p>
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($user->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($user->updated_at) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Is Active') ?></h6>
            <p><?= $this->Bool->prefYes($user->is_active) ?></p>
            <h6 class="subheader"><?= __('Is Password Expired') ?></h6>
            <p><?= $this->Bool->prefYes($user->is_password_expired); ?></p>
            <h6 class="subheader"><?= __('Is Notified') ?></h6>
            <p><?= $this->Bool->prefYes($user->is_notified); ?></p>
            <h6 class="subheader"><?= __('Is Admin') ?></h6>
            <p><?= $this->Bool->prefNo($user->is_admin); ?></p>
        </div>
    </div>
</div>
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Messages') ?></h4>
    <?php if (!empty($user->messages)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Note') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->messages as $messages): ?>
        <tr>
            <td><?= h($messages->id) ?></td>
            <td><?= h($messages->user_id) ?></td>
            <td><?= h($messages->note) ?></td>
            <td><?= h($messages->created_at) ?></td>
            <td><?= h($messages->updated_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Messages', 'action' => 'view', $messages->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Messages', 'action' => 'edit', $messages->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Messages', 'action' => 'delete', $messages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messages->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Payrolls') ?></h4>
    <?php if (!empty($user->payrolls)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Date Worked') ?></th>
            <th><?= __('Start Time') ?></th>
            <th><?= __('End Time') ?></th>
            <th><?= __('Is Paid') ?></th>
            <th><?= __('Notes') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Show Id') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->payrolls as $payrolls): ?>
        <tr>
            <td><?= h($payrolls->id) ?></td>
            <td><?= h($payrolls->date_worked) ?></td>
            <td><?= h($payrolls->start_time) ?></td>
            <td><?= h($payrolls->end_time) ?></td>
            <td><?= h($payrolls->is_paid) ?></td>
            <td><?= h($payrolls->notes) ?></td>
            <td><?= h($payrolls->user_id) ?></td>
            <td><?= h($payrolls->show_id) ?></td>
            <td><?= h($payrolls->created_at) ?></td>
            <td><?= h($payrolls->updated_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Payrolls', 'action' => 'view', $payrolls->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Payrolls', 'action' => 'edit', $payrolls->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payrolls', 'action' => 'delete', $payrolls->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrolls->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<?php /*
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Show User Perms') ?></h4>
    <?php if (!empty($user->show_user_perms)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('User Id') ?></th>
            <th><?= __('Show Id') ?></th>
            <th><?= __('Is Pay Admin') ?></th>
            <th><?= __('Is Paid') ?></th>
            <th><?= __('Is Budget') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->show_user_perms as $showUserPerms): ?>
        <tr>
            <td><?= h($showUserPerms->user_id) ?></td>
            <td><?= h($showUserPerms->show_id) ?></td>
            <td><?= h($showUserPerms->is_pay_admin) ?></td>
            <td><?= h($showUserPerms->is_paid) ?></td>
            <td><?= h($showUserPerms->is_budget) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'ShowUserPerms', 'action' => 'view', $showUserPerms->]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'ShowUserPerms', 'action' => 'edit', $showUserPerms->]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ShowUserPerms', 'action' => 'delete', $showUserPerms->], ['confirm' => __('Are you sure you want to delete # {0}?', $showUserPerms->)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div> /* ?>
