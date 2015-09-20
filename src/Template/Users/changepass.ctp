<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Change Password') ?></legend>
        <?php
            echo $this->Form->input('password', ['label' => __("New Password")]);
        ?>
        <input type="hidden" name="is_password_expired" value="0">
    </fieldset>
    <?= $this->Form->button(__('Change Password'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart('Change Password'); ?>
<p>This display allows you change your password. If you forget your password, please contact your system administrator to have it reset.</p>
<?= $this->Pretty->helpMeEnd(); ?>