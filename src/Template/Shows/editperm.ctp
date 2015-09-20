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
        <thead>
            <?= $this->Html->tableHeaders([
                __("Full Name"),

                [ __("Budget User") . ' ' . "<div class='btn-group'>" .
                    $this->Pretty->jqButton(
                        'ok',
                        'default',
                        'buserAllOn',
                        'toggleState',
                        'Toggle All YES' ) .
                    $this->Pretty->jqButton(
                        'remove',
                        'default',
                        'buserAllOff',
                        'toggleState',
                        'Toggle All NO' ) .
                    "</div>"
                    => ['class' => 'info text-center' ]
                ],
                
                [ __("Payroll Admin") . ' ' . "<div class='btn-group'>" .
                    $this->Pretty->jqButton(
                        'ok',
                        'default',
                        'padminAllOn',
                        'toggleState',
                        'Toggle All YES' ) .
                    $this->Pretty->jqButton(
                        'remove',
                        'default',
                        'padminAllOff',
                        'toggleState',
                        'Toggle All NO' ) .
                    "</div>"
                    => ['class' => 'danger text-center' ]
                ],

                [ __("Payroll User") . ' ' . "<div class='btn-group'>" .
                    $this->Pretty->jqButton(
                        'ok',
                        'default',
                        'paidAllOn',
                        'toggleState',
                        'Toggle All YES' ) .
                    $this->Pretty->jqButton(
                        'remove',
                        'default',
                        'paidAllOff',
                        'toggleState',
                        'Toggle All NO' ) .
                    "</div>"
                    => ['class' => 'success text-center' ]
                ],
            ]); ?>
        </thead>
        <tbody>
        <?php
            foreach ( $users as $user ) {
                 echo $this->Html->tableCells([
                    [
                        "<input type='hidden' name='users[]' value='" . $user->id . "'>" . $user->first . " " . $user->last,
                        [
                            $this->Pretty->check(
                                'budget[' . $user->id . ']',
                                $user->perms['is_budget'],
                                [
                                    'on-text' => 'YES',
                                    'off-text' => 'NO',
                                    'on-color' => 'success',
                                    'off-color' => 'danger'
                                ]
                            ), ['class' => 'text-center']
                        ],
                        [
                            $this->Pretty->check(
                                'padmin[' . $user->id . ']',
                                $user->perms['is_pay_admin'],
                                [
                                    'on-text' => 'YES',
                                    'off-text' => 'NO',
                                    'on-color' => 'success',
                                    'off-color' => 'danger'
                                ]
                            ), ['class' => 'text-center']
                        ],
                        [
                            $this->Pretty->check(
                                'paid[' . $user->id . ']',
                                $user->perms['is_paid'],
                                [
                                    'on-text' => 'YES',
                                    'off-text' => 'NO',
                                    'on-color' => 'success',
                                    'off-color' => 'danger'
                                ]
                            ), ['class' => 'text-center']
                        ],
                    ]
                ]);
            }
        ?>
        </tbody>
    </table>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    </div>
</div>


<?= $this->Pretty->helpMeStart('Edit Show Permissions'); ?>
<p>This display allows you to edit the show's permissions for each active user.</p>
<p><?= _("Near each permission type, you will see two buttons:"); ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('ok', 'default', _('Check Button'), _('Toggle this permission ON for all active users')),
        $this->Pretty->helpButton('remove', 'default', _('X Button'), _('Toggle this permission OFF for all active users'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>

<ul class="list-group">
    <li class="list-group-item label-info">Budget User</li>
    <li class="list-group-item">Budget Users have the ability to add, edit, and delete budget items from the show.</li>
    <li class="list-group-item label-danger">Payroll Admin</li>
    <li class="list-group-item">Payroll admin's have the ability to add, edit, and delete payroll items for any "Payroll User" of the show.  Most useful for group supervisors that do not need full system administrator access.  Payroll admin's may also view the payroll report from the show. System administrators can not automatically add payroll items, although they may view any payroll report from any show.</li>
    <li class="list-group-item label-success">Payroll  User</li>
    <li class="list-group-item">Payroll users may add payroll items to the show.  They may edit or delete those payroll hours that have not yet been marked as "paid". Only payroll users appear on the payroll report for the show.</li>
</ul>

<?= $this->Pretty->helpMeEnd(); ?>