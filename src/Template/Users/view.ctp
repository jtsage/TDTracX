<div class="users view large-10 medium-9 columns">
    <h3><?= h($user->first) . " " . h($user->last) ?>
    <?= $this->Html->link(
        $this->Pretty->iconEdit($user->username),
        ['action' => 'edit', $user->id],
        ['escape' => false]
    ) ?>
    <?= $this->Html->link(
        $this->Pretty->iconLock($user->username),
        ['action' => 'changepass', $user->id],
        ['escape' => false]
    ) ?>
    </h3>
    <div class="row">
        <div class="col-md-4">
            <h4><span class="label label-primary"><?= __('Username') ?></span></h4>
            <p><?= h($user->username) ?></p>
            <h4><span class="label label-primary"><?= __('Full Name') ?></span></h4>
            <p><?= h($user->first) ?> <?= h($user->last) ?></p>
            <h4><span class="label label-info"><?= __('Phone Number') ?></span></h4>
            <p><?= $this->Pretty->phone($user->phone) ?></p>
            <h4><span class="label label-info"><?= __('Time Zone') ?></span></h4>
            <p><?= h($user->time_zone) ?></p>
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
            <p><?= $this->Bool->prefNo($user->is_password_expired); ?></p>
            <h4><span class="label label-success"><?= __('Notifications Active?') ?></span></h4>
            <p><?= $this->Bool->prefYes($user->is_notified); ?></p>
            <h4><span class="label label-success"><?= __('Administrator?') ?></span></h4>
            <p><?= $this->Bool->prefNo($user->is_admin); ?></p>
        </div>
    </div>
</div>

<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Show Permissions') ?></h4>
    <?php if (!empty($user->show_user_perms)): ?>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-info"><?= __("Budget User") ?></li>
            <?php foreach ($user->show_user_perms as $showUserPerms) {
                if ($showUserPerms->is_budget) { 
                    echo "<li class='list-group-item'>";
                    echo h($showUserPerms->show->name);
                    echo "</li>";
                }
            } ?>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-danger"><?= __("Payroll Admin") ?></li>
            <?php foreach ($user->show_user_perms as $showUserPerms) {
                if ($showUserPerms->is_pay_admin) { 
                    echo "<li class='list-group-item'>";
                    echo h($showUserPerms->show->name);
                    echo "</li>";
                }
            } ?>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-success"><?= __("Payroll User") ?></li>
            <?php foreach ($user->show_user_perms as $showUserPerms) {
                if ($showUserPerms->is_paid) { 
                    echo "<li class='list-group-item'>";
                    echo h($showUserPerms->show->name);
                    echo "</li>";
                }
            } ?>
            </ul>
        </div>

    </div>

    <?php endif; ?>
    </div>
</div>


<div class="related">
    <a name="messages"></a>
    <div class="column large-12">
    <h4 class="subheader"><?= __('Waiting Messages') ?></h4>
    <?php if (!empty($user->messages)): ?>
    <table class="table table-striped">
        <tr>
            <th><?= __('Created At') ?></th>
            <th><?= __('Message') ?></th>
            
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->messages as $messages): ?>
        <tr>
            <td><?= $messages->created_at->i18nFormat(null, $tz); ?></td>
            <td><?= h($messages->note) ?></td>
            

            <td class="actions">
                 <?= $this->Form->postLink(
                    $this->Pretty->iconDelete($messages->id),
                    ['controller' => 'Messages', 'action' => 'delete', $messages->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $messages->id)]
                ) ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>