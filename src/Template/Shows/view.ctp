<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Show'), ['action' => 'edit', $show->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Show'), ['action' => 'delete', $show->id], ['confirm' => __('Are you sure you want to delete # {0}?', $show->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Budgets'), ['controller' => 'Budgets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Budget'), ['controller' => 'Budgets', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payrolls'), ['controller' => 'Payrolls', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payroll'), ['controller' => 'Payrolls', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Show User Perms'), ['controller' => 'ShowUserPerms', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show User Perm'), ['controller' => 'ShowUserPerms', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="shows view large-10 medium-9 columns">
    <h2><?= h($show->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($show->name) ?></p>
            <h6 class="subheader"><?= __('Location') ?></h6>
            <p><?= h($show->location) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($show->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('End Date') ?></h6>
            <p><?= h($show->end_date) ?></p>
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($show->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($show->updated_at) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Is Active') ?></h6>
            <p><?= $show->is_active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Budgets') ?></h4>
    <?php if (!empty($show->budgets)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Category') ?></th>
            <th><?= __('Vendor') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Date') ?></th>
            <th><?= __('Price') ?></th>
            <th><?= __('Show Id') ?></th>
            <th><?= __('Created At') ?></th>
            <th><?= __('Updated At') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($show->budgets as $budgets): ?>
        <tr>
            <td><?= h($budgets->id) ?></td>
            <td><?= h($budgets->category) ?></td>
            <td><?= h($budgets->vendor) ?></td>
            <td><?= h($budgets->description) ?></td>
            <td><?= h($budgets->date) ?></td>
            <td><?= h($budgets->price) ?></td>
            <td><?= h($budgets->show_id) ?></td>
            <td><?= h($budgets->created_at) ?></td>
            <td><?= h($budgets->updated_at) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Budgets', 'action' => 'view', $budgets->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Budgets', 'action' => 'edit', $budgets->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Budgets', 'action' => 'delete', $budgets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $budgets->id)]) ?>

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
    <?php if (!empty($show->payrolls)): ?>
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
        <?php foreach ($show->payrolls as $payrolls): ?>
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
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Show User Perms') ?></h4>
    <?php if (!empty($show->show_user_perms)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('User Id') ?></th>
            <th><?= __('Show Id') ?></th>
            <th><?= __('Is Pay Admin') ?></th>
            <th><?= __('Is Paid') ?></th>
            <th><?= __('Is Budget') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($show->show_user_perms as $showUserPerms): ?>
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
</div>
