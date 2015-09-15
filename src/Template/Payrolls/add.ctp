<div class="payrolls form large-10 medium-9 columns">
    <?= $this->Form->create($payroll) ?>
    <fieldset>
        <legend><?= __('Add Payroll Item') ?></legend>
        <?php
            echo $this->Form->input('show_id', ['options' => $shows]);
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('notes');
            echo $this->Form->input('date_worked');
            echo $this->Form->input('start_time', ['interval' => 15, 'default' => '9:00:00', 'timeFormat' => 12]);
            echo $this->Form->input('end_time', ['interval' => 15, 'default' => '16:00:00', 'timeFormat' => 12]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
