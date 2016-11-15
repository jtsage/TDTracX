<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
            echo $this->Form->input('first', ['label' => __("First Name")]);
            echo $this->Form->input('last', ['label' => __("Last Name")]);
            echo $this->Form->input('phone', ['label' => __("Phone Number")]);
        ?>
        <div class="form-group"><label class="control-label"><?= __("Time Zone") ?></label>
        <?php
            echo $this->Form->select(
                'time_zone',
                array_combine(timezone_identifiers_list(), timezone_identifiers_list()),
                [ 'default' => 'America/Detroit', 'class' => 'form-control' ]
            );
        ?>
        </div>
        <label>Switches</label>
        <?php
            echo $this->Pretty->check('is_active', $user->is_active, [
                'label-width' => '100',
                'label-text' => __('Is Active'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'on-color' => 'success',
                'off-color' => 'danger'
            ]);
            echo $this->Pretty->check('is_salary', $user->is_salary, [
                'label-width' => '100',
                'label-text' => __('Is Salary'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'on-color' => 'danger',
                'off-color' => 'success'
            ]);
            echo $this->Pretty->check('is_password_expired', $user->is_password_expired, [
                'label-width' => '100',
                'label-text' => __('Is Pass Expired'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'off-color' => 'success',
                'on-color' => 'danger'
            ]);
            echo $this->Pretty->check('is_notified', $user->is_notified, [
                'label-width' => '100',
                'label-text' => __('Is Notified'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'on-color' => 'success',
                'off-color' => 'danger'
            ]);
            echo $this->Pretty->check('is_admin', $user->is_admin, [
                'label-width' => '100',
                'label-text' => __('Is Admin'),
                'on-text' => __('YES'),
                'off-text' => __('NO'),
                'off-color' => 'success',
                'on-color' => 'danger'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart(__('Edit User')); ?>
<p><?= __('This display allows you to edit a user in the system. This display is only available to system administrators.') ?></p>
<table class="table table-condensed helptable">
<?= $this->Html->tableCells([
    [__("E-Mail Address"),  __("User's e-mail address, used for login and notifications.")],
    [__("First Name"),      __("User's first name")],
    [__("Last Name"),       __("User's last name")],
    [__("Phone Number"),    __("User's 10-digit phone number, no punctuation.")],
    [__("Time Zone"),       __("User's time zone. Defaults to EST/EDT (USA).")],
    [__("Is Active"),       __("When checked, the user can login.")],
    [__("Is Salary"),          __("User is a salary employee, mark hours paid by default")],
    [__("Is Pass Expired"), __("When checked, the user will be reminded to change their password on login - but not forced.")],
    [__("Is Notified"),     __("User is notified when a payroll admin adds hours for this user, and when automatic \"payroll is due\" e-mails are sent.")],
    [__("Is Admin"),        __("User's is a system administrator. This grants addition tools, and the user will recieve automatic payroll reports.")]
]); ?>
</table>
<?= $this->Pretty->helpMeEnd(); ?>
