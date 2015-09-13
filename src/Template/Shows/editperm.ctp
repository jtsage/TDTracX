<div class="shows view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) . " " . __("Permissions") ?>
    </h3>
    <div class="row">
        <div class="col-md-6">
            <h4><span class="label label-primary"><?= __('Name') ?></span></h4>
            <p><?= h($show->name) ?></p>
            <h4><span class="label label-primary"><?= __('Location') ?></span></h4>
            <p><?= h($show->location) ?></p>
        </div>
        <div class="col-md-6">
            <h4><span class="label label-success"><?= __('Active Show?') ?></span></h4>
            <p><?= $this->Bool->prefYes($show->is_active) ?></p>
            <h4><span class="label label-success"><?= __('End Date') ?></span></h4>
            <p><?= $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></p>
        </div>
    </div>
</div>

<div class="related">
    <div class="column large-12">
    <h4 class="subheader"><?= __('User Permissions') ?></h4>
    
    <?= $this->Form->create($show) ?>

    <table class="table table-bordered">
        <thead><tr>
            <th><?= __("Full Name") ?></th>
            <th class="info"><?= __("Budget User") ?></th>
            <th class="danger"><?= __("Payroll Admin") ?></th>
            <th class="success"><?= __("Payroll User") ?></th>
        </tr></thead>
        <tbody>
        <?php
            foreach ( $users as $user ) {
                echo "<tr>";
                echo "<td><input type='hidden' name='users[]' value='" . $user->id . "'>" . $user->first . " " . $user->last . "</td>";
                echo "<td>" . $this->Pretty->onoff('budget[' . $user->id . ']', $user->perms['is_budget']) . "</td>";
                echo "<td>" . $this->Pretty->onoff('padmin[' . $user->id . ']', $user->perms['is_pay_admin']) . "</td>";
                echo "<td>" . $this->Pretty->onoff('paid[' . $user->id . ']', $user->perms['is_paid']) . "</td>";
                echo "</tr>\n";
            }
        ?>
        </tbody>
    </table>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

    <?php /*if (!empty($show->show_user_perms)): ?>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
            <li class="list-group-item label-primart">Budget Users</li>
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
            <li class="list-group-item label-danger">Payroll Admins</li>
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
            <li class="list-group-item label-success">Payroll Users</li>
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
   


    <?php endif; */ ?>
    </div>
</div>