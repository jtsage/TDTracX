<h3><?= __("User List") ?>
    <?= $this->Html->link(
        $this->Pretty->iconAdd(__("User")),
        ['action' => 'add'],
        ['escape' => false, 'class' => 'btn btn-success btn-sm']
    ) ?>
</h3>

<div class="users index large-10 medium-9 columns">
    <table class="table table-hover">
    <thead>
        <?= $this->Html->tableHeaders([
            $this->Paginator->sort('username', __("E-Mail")),
            $this->Paginator->sort('last', __("Full Name")),
            __('Phone Number'),
            $this->Paginator->sort('is_active', __("Active User")),
            $this->Paginator->sort('is_admin', __("Administrator"), ['direction' => 'desc']),
            $this->Paginator->sort('last_login_at', __("Last Login"), ['direction' => 'desc']),
            [__('Actions') => ['class' => 'text-center']]
        ]); ?>

    </thead>
    <tbody>
    <?php foreach ($users as $user) {
        echo $this->Html->tableCells([
            [
                h($user->username),
                h($user->first) . " " .  h($user->last),
                $this->Pretty->phone($user->phone),
                $this->Bool->prefYes($user->is_active),
                $this->Bool->prefNo($user->is_admin),
                $user->last_login_at->i18nFormat(null, $tz),
                [  
                    '<div class="btn-group" role="group" aria-label="...">' .
                    $this->Html->link(
                        $this->Pretty->iconView($user->username),
                        ['action' => 'view', $user->id],
                        ['escape' => false, 'class' => 'btn btn-default btn-sm']
                    ) . 
                    $this->Html->link(
                        $this->Pretty->iconLock($user->username),
                        ['action' => 'changepass', $user->id],
                        ['escape' => false, 'class' => 'btn btn-default btn-sm']
                    ) .
                    $this->Html->link(
                        $this->Pretty->iconEdit($user->username),
                        ['action' => 'edit', $user->id],
                        ['escape' => false, 'class' => 'btn btn-default btn-sm']
                    ) .
                    $this->Form->postLink(
                        $this->Pretty->iconDelete($user->username),
                        ['action' => 'delete', $user->id],
                        ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-danger btn-sm']
                    ) .
                    '</div>',
                    ['class' => 'text-center']
                ]
            ]
        ]);
    } ?>

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

<?= $this->Pretty->helpMeStart('User List'); ?>
<p><?= _('This system administrator only display shows users associated with this system. "Administrators" are users with super user privledges.  "Active" users can login and be assigned permission roles.') ?></p>
<p><?= _('Near the title, you will see one button:') ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('plus', 'success', _('Plus Button'), _('Add a user to the system'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>

<p><?= _('For each user, you will see four buttons:') ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('eye-open', 'default', _('Eye Button'), _('View a detailed user record')),
        $this->Pretty->helpButton('lock', 'default', _('Lock Button'), _('Change the user\'s password')),
        $this->Pretty->helpButton('pencil', 'default', _('Pencil Button'), _('Edit the user record')),
        $this->Pretty->helpButton('trash', 'danger', _('Trash Button'), _('Permanantly remove the user from the system, and all historical data about them.  Very, very destructive - use with extream caution.'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>



<?= $this->Pretty->helpMeEnd(); ?>