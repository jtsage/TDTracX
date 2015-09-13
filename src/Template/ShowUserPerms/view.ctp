<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Show User Perm'), ['action' => 'edit', $showUserPerm->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Show User Perm'), ['action' => 'delete', $showUserPerm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $showUserPerm->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Show User Perms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show User Perm'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="showUserPerms view large-10 medium-9 columns">
    <h2><?= h($showUserPerm->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $showUserPerm->has('user') ? $this->Html->link($showUserPerm->user->id, ['controller' => 'Users', 'action' => 'view', $showUserPerm->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Show') ?></h6>
            <p><?= $showUserPerm->has('show') ? $this->Html->link($showUserPerm->show->name, ['controller' => 'Shows', 'action' => 'view', $showUserPerm->show->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($showUserPerm->id) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Is Pay Admin') ?></h6>
            <p><?= $showUserPerm->is_pay_admin ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Is Paid') ?></h6>
            <p><?= $showUserPerm->is_paid ? __('Yes') : __('No'); ?></p>
            <h6 class="subheader"><?= __('Is Budget') ?></h6>
            <p><?= $showUserPerm->is_budget ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
