<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
            echo $this->Form->input('password', ['label' => 'Password', 'data-minlength' => 6]);
            echo $this->Form->input('first', ['label' => __("First Name")]);
            echo $this->Form->input('last', ['label' => __("Last Name")]);
            echo $this->Form->input('phone', ['label' => __("Phone Number")]);
            echo $this->Form->input('pay_rate', ['label' => __("Pay Rate")]);
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
    </fieldset>
    <?= $this->Form->button(__('Add'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart(__('Add User')); ?>

<p><?= __('This display allows you to add a new user in the system. This display is only available to system administrators.') ?></p>
<table class="table table-condensed helptable">
<?= $this->Html->tableCells([
    [__("E-Mail Address"),  __("User's e-mail address, used for login and notifications.")],
    [__("Password"),        __("User's initial password.")],
    [__("First Name"),      __("User's first name")],
    [__("Last Name"),       __("User's last name")],
    [__("Phone Number"),    __("User's 10-digit phone number, no punctuation.")],
    [__("Pay Rate"),        __("User's Pay Rate.")],
    [__("Time Zone"),       __("User's time zone. Defaults to EST/EDT (USA).")]
]); ?>
</table>

<?= $this->Pretty->helpMeEnd(); ?>