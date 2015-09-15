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
<p>This display allows you to edit a user in the system. This display is only available to system administrators.</p>
<ul class="list-group">
    <li class="list-group-item"><strong>E-Mail</strong>: User's e-mail address, used for login and notifications.</li>
    <li class="list-group-item"><strong>First</strong>: User's first name</li>
    <li class="list-group-item"><strong>Last</strong>: User's last name</li>
    <li class="list-group-item"><strong>Phone</strong>: User's 10-digit phone number, no punctuation.</li>
    <li class="list-group-item"><strong>Pay Rate</strong>: User's Pay Rate.</li>
    <li class="list-group-item"><strong>Time Zone</strong>: User's time zone. Defaults to EST/EDT (USA).</li>
    <li class="list-group-item"><strong>Is Active</strong>: When checked, the user can login.</li>
    <li class="list-group-item"><strong>Is Password Expired</strong>: When checked, the user will be reminded to change their password on login - but not forced.</li>
    <li class="list-group-item"><strong>Is Notified</strong>: User is notified when a payroll admin adds hours for this user, and when automatic "payroll is due" e-mails are sent.</li>
    <li class="list-group-item"><strong>Is Admin</strong>: User's is a system administrator. This grants addition tools, and the user will recieve automatic payroll reports.</li>
</ul>
<?= $this->Pretty->helpMeEnd(); ?>
