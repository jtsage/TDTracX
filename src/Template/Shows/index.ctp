<h3><?= __("Show List"); ?>
    <?= $this->Html->link(
        $this->Pretty->iconAdd(__("Show")),
        ['action' => 'add'],
        ['escape' => false]
    ) ?>
</h3>
<div class="shows index large-10 medium-9 columns">
    <table class="table table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('location') ?></th>
            <th><?= $this->Paginator->sort('end_date') ?></th>
            <th><?= $this->Paginator->sort('is_active') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($shows as $show): ?>
        <tr>
            <td><?= h($show->name) ?></td>
            <td><?= h($show->location) ?></td>
            <td><?= $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></td>
            <td><?= $this->Bool->prefYes($show->is_active) ?></td>
            
            <td class="actions">
                <?= $this->Html->link(
                    $this->Pretty->iconView($show->name),
                    ['action' => 'view', $show->id],
                    ['escape' => false]
                ) ?>
                <?= $this->Html->link(
                    $this->Pretty->iconEdit($show->name),
                    ['action' => 'edit', $show->id],
                    ['escape' => false]
                ) ?>
                <?= $this->Html->link(
                    $this->Pretty->iconPerm($show->name),
                    ['action' => 'editperm', $show->id],
                    ['escape' => false]
                ) ?>
                <?= $this->Form->postLink(
                    $this->Pretty->iconDelete($show->name),
                    ['action' => 'delete', $show->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $show->id)]
                ) ?>
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
