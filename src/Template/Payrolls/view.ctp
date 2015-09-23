<div class="shows view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) . __(" Payroll Expenditure") ?>
        <div class='btn-group'>
        <?= ( isset($show_add) && $show_add ) ? $this->Html->link(
                $this->Pretty->iconAdd($show->name . " " . __("Payroll Item")),
                ['action' => 'addtoshow', $show->id],
                ['escape' => false, 'class' => 'btn btn-success btn-sm']
            ) : "" ?>
        <?= ( isset($show_add) && $show_add  ) ? 
            $this->Form->postLink(
                $this->Pretty->iconMark($show->name),
                ['action' => 'markshowpaid', $show->id],
                ['escape' => false, 'confirm' => __('Are you sure you want to mark ALL paid for {0}?', $show->name),  'class' => 'btn btn-warning btn-sm']) : "";
        ?>
        <?= $this->Html->link(
                $this->Pretty->iconDL($show->name . " " . __("Payroll Item")),
                ['action' => 'viewbyshow', $show->id, 'csv'],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']);
        ?>
        </div>
    </h3>
</div>

<?php if( isset($orphans) ) : ?>
<div role="alert" class="alert alert-dismissible fade in alert-warning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>This show has orphaned payroll records by:
<?php
    $list = [];
    foreach ( $orphans as $orphan ) {
        $list[] = $orphan->fullname;
    }
    echo join(', ', $list);
?>
. <a class="alert-link" href="/shows/editperm/<?= $show->id ?>">Fix It</a>
</div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead>
        <?= $this->Html->tableHeaders([
            __("Date Worked"),
            __("Note"),
            [__("Start Time") => ['class' => 'text-right']],
            [__("End Time") => ['class' => 'text-right']],
            [__("Hours Worked") => ['class' => 'text-right']],
            [__("Is Paid?") => ['class' => 'text-center']],
            [__("Actions") => ['class' => 'text-center']]
        ]); ?>
    </thead>
    <tbody>
        <?php 

        $total = 0;
        $subtotal = 0;
        $lastuser = "";

        foreach ( $payrolls as $item ) {
            if ( $item->fullname <> $lastuser ) {
                if ( $subtotal > 0 ) {
                    echo $this->Html->tableCells([
                        [
                            [ __('User Sub-Total') . ": " . $lastuser , ['colspan' => 4]],
                            [number_format($subtotal,2), ['class' => 'text-right']],
                            [ "", ['colspan' => 2]]
                        ]
                    ], ['class' => 'success bold'], null, 1, false);  
                }
                echo $this->Html->tableCells([
                    [
                        [ __('User') . ": " . $item->fullname , ['colspan' => 7]]
                    ]
                ], ['class' => 'info bold'], null, 1, false); 

                $subtotal = 0;
                $lastuser = $item->fullname;
            }

            echo $this->Html->tableCells([
                [
                    $item->date_worked->i18nFormat('EEE, MMM dd, yyyy', 'UTC'),
                    $item->notes,
                    [$item->start_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'), ['class' => 'text-right']],
                    [$item->end_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'), ['class' => 'text-right']],
                    [ number_format($item->worked, 2), ['class' => 'text-right']],
                    [
                        ( ( isset($show_add) && $show_add && !$item->is_paid ) ?
                            $this->Form->postLink(
                                $this->Pretty->iconMark($item->notes),
                                ['action' => 'markpaid', $item->id],
                                ['escape' => false, 'confirm' => __('Are you sure you want to mark paid # {0}?', $item->id), 'class' => 'btn btn-warning btn-sm']) : "" ) . " " .
                        $this->Bool->prefYes($item->is_paid), ['class' => 'text-center']
                    ],
                    [
                        ( ( (isset($show_add) && $show_add) || !$item->is_paid ) ?
                            $this->Html->link(
                                $this->Pretty->iconEdit($item->notes),
                                ['action' => 'edit', $item->id],
                                ['escape' => false, 'class' => 'btn btn-default btn-sm']) .
                            $this->Form->postLink(
                                $this->Pretty->iconDelete($item->notes),
                                ['action' => 'delete', $item->id],
                                ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $item->id), 'class' => 'btn btn-danger btn-sm'])
                            : "" ),
                        ['class' => 'text-center']
                    ]
                ]
            ]);

            $subtotal += $item->worked;
            $total += $item->worked;
        }
        if ( $total > 0 ) {
            echo $this->Html->tableCells([
                [
                    [ __('User Sub-Total') . ": " . $lastuser , ['colspan' => 4]],
                    [number_format($subtotal,2), ['class' => 'text-right']],
                    [ "", ['colspan' => 2]]
                ]
            ], ['class' => 'success bold'], null, 1, false);  

            echo $this->Html->tableCells([
                [
                    [ __('Total Hours'), ['colspan' => 4]],
                    [number_format($total,2), ['class' => 'text-right']],
                    [ "", ['colspan' => 2]]
                ]
            ], ['class' => 'danger bold'], null, 1, false);
        }

        ?>
    </tbody>
</table>


<?= $this->Pretty->helpMeStart('View Show Payroll Report'); ?>
<p><?= __("This display shows the payroll report for the specified show, broken down by user") ?></p>
<p><?= __("After the show name, you may see the following buttons: (<em>Note: only payroll admin's my add direct to a show or mark records as paid</em>)") ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('plus', 'success', __('Plus Button'), __('Add a payroll record to the show')),
        $this->Pretty->helpButton('check', 'warning', __('Check Button'), __('Mark ALL payroll records paid')),
        $this->Pretty->helpButton('cloud-download', 'default', __('Download Button'), __('Download a CSV file for offline printing or editing'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>

<p><?= __("For each entry, you may see these three buttons:") ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('check', 'warning', __('Check Button'), __('Mark the payroll record paid')),
        $this->Pretty->helpButton('pencil', 'default', __('Pencil Button'), __('Edit the payroll record')),
        $this->Pretty->helpButton('trash', 'danger', __('Trash Button'), __('Remove the payroll record'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>

<p><?= __("Only payroll admin's may mark records paid.  Regular payroll users may only edit or delete payroll records that have not yet been marked paid.") ?></p>

<h4><?= __("Orphaned Records Warning") ?></h4>
<p><?= __("System administrators may see a warning about orphaned records.  This is caused when a user adds payroll records and is later denied access to a show.  These records will not print on any reports, but they will cause the totals on the dashboard to be incorrect.  To fix these, you will need to re-grant access to that user before removing those records.") ?></p>
<?= $this->Pretty->helpMeEnd(); ?>