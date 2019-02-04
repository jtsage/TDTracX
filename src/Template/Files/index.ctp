<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
 */
?>
<h3>
    <?= __("Files"); ?>
    <div class="btn-group">
        <?php echo $this->Html->link(
            $this->Pretty->iconAdd(__("File")),
            ['action' => 'add'],
            ['escape' => false, 'class' => 'btn btn-success btn-sm']
        ); ?>
        </div>
</h3>

<div class="files index large-9 medium-8 columns content">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dsc') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): ?>
            <tr>
                <td><?= $this->Number->format($file->id) ?></td>
                <td><?= h($file->name) ?></td>
                <td><?= h($file->dsc) ?></td>



                <td class="actions text-center">
                    <div class='btn-group'>
                            <?= $this->Html->link(
                                $this->Pretty->iconDL($file->dsc),
                                ['action' => 'view', $file->id],
                                ['escape' => false, 'class' => 'btn btn-default btn-sm' ] ) ?>
                            
                            <?= $this->Form->postLink(
                                $this->Pretty->iconDelete($file->dsc),
                                ['action' => 'delete', $file->id],
                                ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $file->id), 'class' => 'btn btn-danger btn-sm' ] ) ?>
                            
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
