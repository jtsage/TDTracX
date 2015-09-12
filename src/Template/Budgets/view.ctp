<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Budget'), ['action' => 'edit', $budget->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Budget'), ['action' => 'delete', $budget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Budgets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Budget'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Shows'), ['controller' => 'Shows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Show'), ['controller' => 'Shows', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="budgets view large-10 medium-9 columns">
    <h2><?= h($budget->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Category') ?></h6>
            <p><?= h($budget->category) ?></p>
            <h6 class="subheader"><?= __('Vendor') ?></h6>
            <p><?= h($budget->vendor) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($budget->description) ?></p>
            <h6 class="subheader"><?= __('Show') ?></h6>
            <p><?= $budget->has('show') ? $this->Html->link($budget->show->name, ['controller' => 'Shows', 'action' => 'view', $budget->show->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($budget->id) ?></p>
            <h6 class="subheader"><?= __('Price') ?></h6>
            <p><?= $this->Number->format($budget->price) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date') ?></h6>
            <p><?= h($budget->date) ?></p>
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($budget->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($budget->updated_at) ?></p>
        </div>
    </div>
</div>
