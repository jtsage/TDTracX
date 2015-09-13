<div class="shows view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) ?>
        <?= $this->Html->link(
            $this->Pretty->iconEdit($show->name),
            ['action' => 'edit', $show->id],
            ['escape' => false]
        ) ?>
        <?= $this->Html->link(
            $this->Pretty->iconPerm($show->name),
            ['action' => 'editperm', $show->id],
            ['escape' => false]
        ) ?>
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
                if ($showUserPerms->is_budget) { 
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
                if ($showUserPerms->is_pay_admin) { 
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
                if ($showUserPerms->is_paid) { 
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
