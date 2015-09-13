<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Change Password') ?></legend>
        <?php
            echo $this->Form->input('password', ['label' => __("New Password")]);
        ?>
        <input type="hidden" name="is_password_expired" value="0">
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
