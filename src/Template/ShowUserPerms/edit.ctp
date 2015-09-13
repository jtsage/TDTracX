<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $showUserPerm->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $showUserPerm->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Show User Perms'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="showUserPerms form large-10 medium-9 columns">
    <?= $this->Form->create($showUserPerm) ?>
    <fieldset>
        <legend><?= __('Edit Show User Perm') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('show_id', ['options' => $shows]);
            echo $this->Form->input('is_pay_admin');
            echo $this->Form->input('is_paid');
            echo $this->Form->input('is_budget');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
