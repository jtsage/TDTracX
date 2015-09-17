<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
            echo $this->Form->input('first', ['label' => __("First Name")]);
            echo $this->Form->input('last', ['label' => __("Last Name")]);
            echo $this->Form->input('phone', ['label' => __("Phone Number")]);
            echo $this->Form->input('pay_rate', ['label' => __("Pay Rate")]);
        ?>
        <div class="form-group"><label class="control-label">Time Zone</label>
        <?php
            echo $this->Form->select(
                'time_zone',
                array_combine(timezone_identifiers_list(), timezone_identifiers_list()),
                [ 'default' => 'America/Detroit', 'class' => 'form-control' ]
            );
        ?>
        </div>
        <?php
            echo $this->Form->input('is_active');
            echo $this->Form->input('is_password_expired');
            echo $this->Form->input('is_notified');
            echo $this->Form->input('is_admin');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Edit User'); ?>
<p><?= _('This display allows you to edit a user in the system. This display is only available to system administrators.') ?></p>
<?= $this->Html->nestedList([
        "<strong>E-Mail Address</strong>: User's e-mail address, used for login and notifications.",
        "<strong>First Name</strong>: User's first name",
        "<strong>Last Name</strong>: User's last name",
        "<strong>Phone Number</strong>: User's 10-digit phone number, no punctuation.",
        "<strong>Pay Rate</strong>: User's Pay Rate.",
        "<strong>Time Zone</strong>: User's time zone. Defaults to EST/EDT (USA).",
        "<strong>Is Active</strong>: When checked, the user can login.",
        "<strong>Is Password Expired</strong>: When checked, the user will be reminded to change their password on login - but not forced.",
        "<strong>Is Notified</strong>: User is notified when a payroll admin adds hours for this user, and when automatic \"payroll is due\" e-mails are sent.",
        "<strong>Is Admin</strong>: User's is a system administrator. This grants addition tools, and the user will recieve automatic payroll reports."
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<?= $this->Pretty->helpMeEnd(); ?>
