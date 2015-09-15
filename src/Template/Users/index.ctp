<h3><?= __("User List") ?>
    <?= $this->Html->link(
        $this->Pretty->iconAdd(__("User")),
        ['action' => 'add'],
        ['escape' => false]
    ) ?>
</h3>

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
            <th class="text-center"><?= __('Actions') ?></th>
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
            <td class="text-center">
                <?= $this->Html->link(
                    $this->Pretty->iconView($user->username),
                    ['action' => 'view', $user->id],
                    ['escape' => false]
                ) ?>
                <?= $this->Html->link(
                    $this->Pretty->iconLock($user->username),
                    ['action' => 'changepass', $user->id],
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

<?= $this->Pretty->helpMeStart('View Budgets'); ?>
<p>This system administrator only display shows users associated with this system. "Administrators" are users with super user privledges.  "Active" users can login and be assigned permission roles.</p>
<p>For each user, you will see four buttons:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <strong>Eye Button</strong>: View a detailed user record.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> <strong>Lock Button</strong>: Change the user's password.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <strong>Pencil Button</strong>: Edit the user.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <strong>Trash Button</strong>: Permanantly remove the user from the system, and all historical data about them.  Very, very destructive - use with extream caution.</li>
    
</ul>
<?= $this->Pretty->helpMeEnd(); ?>