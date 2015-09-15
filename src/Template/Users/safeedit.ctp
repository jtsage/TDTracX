<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit Your Account') ?>: <?= $user->username; ?></legend>
        <?php
            echo $this->Form->input('first', ['label' => __("First Name")]);
            echo $this->Form->input('last', ['label' => __("Last Name")]);
            echo $this->Form->input('phone', ['label' => __("Phone Number")]);
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
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Edit Your Account'); ?>
<p>This display allows you to edit your account details.  To change your login e-mail, notification settings or access level, you must contact your system administrator.</p>
<ul class="list-group">
    <li class="list-group-item"><strong>First</strong>: Your first name</li>
    <li class="list-group-item"><strong>Last</strong>: Your last name</li>
    <li class="list-group-item"><strong>Phone</strong>: Your 10-digit phone number, no punctuation.</li>
    <li class="list-group-item"><strong>Time Zone</strong>: Your time zone. Defaults to EST/EDT (USA).</li>
</ul>
<?= $this->Pretty->helpMeEnd(); ?>