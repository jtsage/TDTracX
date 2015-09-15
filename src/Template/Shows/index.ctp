<h3><?= __("Show List"); ?>
    <?= $this->Html->link(
        $this->Pretty->iconAdd(__("Show")),
        ['action' => 'add'],
        ['escape' => false]
    ) ?>
</h3>
<div class="shows index large-10 medium-9 columns">
    <table class="table table-hover">
    <thead>
        <tr class="success">
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('location') ?></th>
            <th><?= $this->Paginator->sort('end_date') ?></th>
            <th><?= $this->Paginator->sort('is_active', __('Is Open'), ['direction' => 'DESC']) ?></th>
            <th class="text-center"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($shows as $show): ?>
        <tr>
            <td><?= h($show->name) ?></td>
            <td><?= h($show->location) ?></td>
            <td><?= $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></td>
            <td><?= $this->Bool->prefYes($show->is_active) ?></td>
            
            <td class="text-center">
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

<?= $this->Pretty->helpMeStart('Show List'); ?>
<p>This display shows the shows that you have access to.</p>
<p>Near the title, you will see one button:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <strong>Plus Button</strong>: Add a show to the system (admin only).</li>
</ul>
<p>For each show, you will see four buttons:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <strong>Eye Button</strong>: View a detailed show record.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <strong>Pencil Button</strong>: Edit the show (admin only).</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <strong>Person Button</strong>: Change the show's permissions (admin only).</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <strong>Trash Button</strong>: Permanantly remove the show from the system, and all historical data about it.  Very, very destructive - use with extream caution (admin only).</li>
    
</ul>
<?= $this->Pretty->helpMeEnd(); ?>
