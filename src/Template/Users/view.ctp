<div class="users view large-10 medium-9 columns">
    <h3><?= h($user->first) . " " . h($user->last) ?>
    <?= $this->Html->link(
        $this->Pretty->iconEdit($user->username),
        ['action' => 'edit', $user->id],
        ['escape' => false]
    ) ?>
    </h3>
    <div class="row">
        <div class="col-md-4">
            <h4><span class="label label-primary"><?= __('Username') ?></span></h4>
            <p><?= h($user->username) ?></p>
            <h4><span class="label label-primary"><?= __('First Name') ?></span></h4>
            <p><?= h($user->first) ?></p>
            <h4><span class="label label-primary"><?= __('Last Name') ?></span></h4>
            <p><?= h($user->last) ?></p>
            <h4><span class="label label-info"><?= __('Phone Number') ?></span></h4>
            <p><?= $this->Pretty->phone($user->phone) ?></p>
        </div>
        <div class="col-md-4">
            <h4><span class="label label-warning"><?= __('Last Login At') ?></span></h4>
            <p><?= $user->last_login_at->i18nFormat(null, $tz); ?></p>
            <h4><span class="label label-warning"><?= __('User Created At') ?></span></h4>
            <p><?= $user->created_at->i18nFormat(null, $tz); ?></p>
            <h4><span class="label label-warning"><?= __('Last Update At') ?></span></h4>
            <p><?= $user->updated_at->i18nFormat(null, $tz); ?></p>
        </div>
        <div class="col-md-4">
            <h4><span class="label label-success"><?= __('Active User?') ?></span></h4>
            <p><?= $this->Bool->prefYes($user->is_active) ?></p>
            <h4><span class="label label-success"><?= __('Expired Password?') ?></span></h4>
            <p><?= $this->Bool->prefYes($user->is_password_expired); ?></p>
            <h4><span class="label label-success"><?= __('Notifications Active?') ?></span></h4>
            <p><?= $this->Bool->prefYes($user->is_notified); ?></p>
            <h4><span class="label label-success"><?= __('Administrator?') ?></span></h4>
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
        <?php  foreach ($user->show_user_perms as $showUserPerms): ?>
        <tr>
            <td><?= h($showUserPerms->user_id) ?></td>
            <td><?= h($showUserPerms->show_id) ?></td>
            <td><?= h($showUserPerms->is_pay_admin) ?></td>
            <td><?= h($showUserPerms->is_paid) ?></td>
            <td><?= h($showUserPerms->is_budget) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Shows', 'action' => 'view', $showUserPerms->show_id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Shows', 'action' => 'edit', $showUserPerms->show_id]) ?>

            </td>
        </tr>

        <?php endforeach;  ?>
    </table>
    <?php endif; ?>
    </div>
</div> 
