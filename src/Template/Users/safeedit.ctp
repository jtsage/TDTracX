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
<p><?= _('This display allows you to edit your account details.  To change your login e-mail, notification settings or access level, you must contact your system administrator.') ?></p>
<?= $this->Html->nestedList([
        "<strong>First Name</strong>: Your first name",
        "<strong>Last Name</strong>: Your last name",
        "<strong>Phone Number</strong>: Your 10-digit phone number, no punctuation.",
        "<strong>Time Zone</strong>: Your time zone. Defaults to EST/EDT (USA)."
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<?= $this->Pretty->helpMeEnd(); ?>