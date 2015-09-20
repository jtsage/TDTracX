<div class="shows view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) ?>
        <div class="btn-group">
        <?= ($isAdmin) ? $this->Html->link(
            $this->Pretty->iconEdit($show->name),
            ['action' => 'edit', $show->id],
            ['escape' => false, 'class' => 'btn btn-default btn-sm']
        ) : "" ?>
        <?= ($isAdmin) ? $this->Html->link(
            $this->Pretty->iconPerm($show->name),
            ['action' => 'editperm', $show->id],
            ['escape' => false, 'class' => 'btn btn-warning btn-sm']
        ) : "" ?>
        </div>
    </h3>
    <div class="row">
        <div class="col-md-6">
            <h4><span class="label label-primary"><?= __('Name') ?></span></h4>
            <p><?= h($show->name) ?></p>
            <h4><span class="label label-primary"><?= __('Location') ?></span></h4>
            <p><?= h($show->location) ?></p>
            <h4><span class="label label-success"><?= __('Active Show?') ?></span></h4>
            <p><?= $this->Bool->prefYes($show->is_active) ?></p>
        </div>
        <div class="col-md-6">
            <h4><span class="label label-success"><?= __('End Date') ?></span></h4>
            <p><?= $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></p>
            <h4><span class="label label-warning"><?= __('User Created At') ?></span></h4>
            <p><?= $show->created_at->i18nFormat(null, $tz); ?></p>
            <h4><span class="label label-warning"><?= __('Last Update At') ?></span></h4>
            <p><?= $show->updated_at->i18nFormat(null, $tz); ?></p>
        </div>
    </div>
</div>
<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('User Permissions') ?></h4>
    <?php if (!empty($show->show_user_perms)): ?>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-info"><?= __("Budget Users") ?></li>
            <?php foreach ($show->show_user_perms as $showUserPerms) {
                if ($showUserPerms->is_budget && $showUserPerms->user->is_active) { 
                    echo "<li class='list-group-item'>";
                    echo h($showUserPerms->user->last) . ", " . h($showUserPerms->user->first);
                    echo "</li>";
                }
            } ?>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-danger"><?= __("Payroll Admins") ?></li>
            <?php foreach ($show->show_user_perms as $showUserPerms) {
                if ($showUserPerms->is_pay_admin && $showUserPerms->user->is_active) { 
                    echo "<li class='list-group-item'>";
                    echo h($showUserPerms->user->last) . ", " . h($showUserPerms->user->first);
                    echo "</li>";
                }
            } ?>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-success"><?= __("Payroll Users") ?></li>
            <?php foreach ($show->show_user_perms as $showUserPerms) {
                if ($showUserPerms->is_paid && $showUserPerms->user->is_active) { 
                    echo "<li class='list-group-item'>";
                    echo h($showUserPerms->user->last) . ", " . h($showUserPerms->user->first);
                    echo "</li>";
                }
            } ?>
            </ul>
        </div>

    </div>

    <?php endif; ?>
    </div>
</div>


<?= $this->Pretty->helpMeStart('View Show Details'); ?>
<p><?= __("This display shows details of the show record, along with the currently assigned permissions"); ?></p>
<p><?= __("Near the show title, you may see two buttons:"); ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('pencil', 'default', __('Pencil Button'), __('Edit the show record (admin only)')),
        $this->Pretty->helpButton('user', 'warning', __('Person Button'), __('Change the show permission lists (admin only)'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>

<h4><?= __('Permissions') ?></h4>
<p><?= __('These lists show the users that the current show has granted permission to. Permissions in TDTracX are on a per-show basis, granting permission on one show does not grant it on any other show.') ?></p>
<ul class="list-group">
    <li class="list-group-item label-info">Budget User</li>
    <li class="list-group-item">Budget Users have the ability to add, edit, and delete budget items from the show.</li>
    <li class="list-group-item label-danger">Payroll Admin</li>
    <li class="list-group-item">Payroll admin's have the ability to add, edit, and delete payroll items for any "Payroll User" of the show.  Most useful for group supervisors that do not need full system administrator access.  Payroll admin's may also view the payroll report from the show. System administrators can not automatically add payroll items, although they may view any payroll report from any show.</li>
    <li class="list-group-item label-success">Payroll  User</li>
    <li class="list-group-item">Payroll users may add payroll items to the show.  They may edit or delete those payroll hours that have not yet been marked as "paid". Only payroll users appear on the payroll report for the show.</li>
</ul>

<?= $this->Pretty->helpMeEnd(); ?>