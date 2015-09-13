<h3><?= __("Show List"); ?>
    <?= $this->Html->link(
        $this->Pretty->iconAdd(__("Show")),
        ['action' => 'add'],
        ['escape' => false]
    ) ?>
</h3>
<div class="shows index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('location') ?></th>
            <th><?= $this->Paginator->sort('end_date') ?></th>
            <th><?= $this->Paginator->sort('is_active') ?></th>
            <th><?= $this->Paginator->sort('created_at') ?></th>
            <th><?= $this->Paginator->sort('updated_at') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($shows as $show): ?>
        <tr>
            <td><?= $this->Number->format($show->id) ?></td>
            <td><?= h($show->name) ?></td>
            <td><?= h($show->location) ?></td>
            <td><?= h($show->end_date) ?></td>
            <td><?= h($show->is_active) ?></td>
            <td><?= h($show->created_at) ?></td>
            <td><?= h($show->updated_at) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $show->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $show->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $show->id], ['confirm' => __('Are you sure you want to delete # {0}?', $show->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
