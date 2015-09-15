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
            <?php if ( isset($showpay) ): ?>
            <h4><span class="label label-danger"><?= __('Pay Rate') ?></span></h4>
            <p><?= $this->Number->currency($user->pay_rate); ?></p>
            <?php endif; ?>
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


<?= $this->Pretty->helpMeStart('View Budgets'); ?>
<p>This display shows details of the user record, along with the currently assigned permissions</p>
<p>Near the user's full name, you will see two buttons:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <strong>Pencil Button</strong>: Edit the user.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> <strong>Lock Button</strong>: Change the user's password.</li>
</ul>
<h4>Permissions</h4>
<p>These lists show the shows that the current user has permissions on. Permissions in TDTracX are on a per-show basis, granting permission on one show does not grant it on any other show.</p>
<ul class="list-group">
    <li class="list-group-item label-info">Budget User</li>
    <li class="list-group-item">Budget Users have the ability to add, edit, and delete budget items from the show.</li>
    <li class="list-group-item label-danger">Payroll Admin</li>
    <li class="list-group-item">Payroll admin's have the ability to add, edit, and delete payroll items for any "Payroll User" of the show.  Most useful for group supervisors that do not need full system administrator access.  Payroll admin's may also view the payroll report from the show. System administrators can not automatically add payroll items, although they may view any payroll report from any show.</li>
    <li class="list-group-item label-success">Payroll User</li>
    <li class="list-group-item">Payroll users may add payroll items to the show.  They may edit or delete those payroll hours that have not yet been marked as "paid". Only payroll users appear on the payroll report for the show.</li>
</ul>

<h4>Messages</h4>
<p>Finally, if there are any messages waiting for the user, they are shown at the bottom of this display, with a delete button.  At this time, there is very little internal messaging used, preferring e-mail to the internal system.</p>
<?= $this->Pretty->helpMeEnd(); ?>