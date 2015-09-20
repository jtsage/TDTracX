
<h3><?= __("Your Payroll Shows"); ?></h3>
<p><?= __("These are shows you are on the payroll for.") ?></p>

<div class="row">
<?php $rowcount = 0; ?>
<?php foreach ( $showsPaid as $item ): ?>
<?php if ( $rowcount == 2 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
<div class="col-md-6">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $item->name ?>
            <div class="btn-group">
                <?= 
                $this->Html->link(
                    $this->Pretty->iconView(__("Your Payroll for ") . $item->name),
                    ['action' => 'viewbyshow', $item->id],
                    ['escape' => false, 'class' => 'btn btn-default btn-sm']
                ) .
                $this->Html->link(
                    $this->Pretty->iconAdd($item->name . " " . __("Payroll Item")),
                    ['action' => 'addtoself', $item->id],
                    ['escape' => false, 'class' => 'btn btn-success btn-sm']
                ); ?>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $worked_paid = 0;
            $worked_owed = 0;

            foreach ( $payPaid as $pitem ) {
                if ( $pitem->show_id == $item->id ) {
                    if ( $pitem->is_paid ) { 
                        $worked_paid = $pitem->totalwork;
                    } else {
                        $worked_owed = $pitem->totalwork;
                    }
                }
            }
        ?>
        <p><?= __("{0}{2}{1} taking place at {0}{3}{1} and ending on {0}{4}{1}", [
            "<strong>",
            "</strong>",
            $item->name,
            $item->location,
            $item->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC')
        ]); ?></p>
        <table class="table table-condensed">
            <tbody>
                <tr class="danger <?= ($worked_owed>0?"bold":"") ?>">
                    <td><?= __("Your Owed Hours") ?></td>
                    <td class='text-right'><?= number_format($worked_owed, 2) ?></td>
                </tr>            
                <tr class="success">
                    <td><?= __("Your Paid Hours") ?></td>
                    <td class='text-right'><?= number_format($worked_paid, 2) ?></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
</div>
<?php endforeach; ?>
</div>


<h3><?= __("Your Administrated Shows"); ?></h3>
<p><?= __("These are shows you are the payroll administrator for.") ?></p>

<div class="row">
<?php $rowcount = 0; ?>
<?php foreach ( $showsPadmin as $item ): ?>
<?php if ( $rowcount == 2 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
<div class="col-md-6">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $item->name ?>
            <div class="btn-group">
            <?= 
            $this->Html->link(
                $this->Pretty->iconView($item->name . " " . __("Payroll")),
                ['action' => 'viewbyshow', $item->id],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) .
            $this->Html->link(
                $this->Pretty->iconUnpaid($item->name),
                ['action' => 'unpaidbyshow', $item->id],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) .
            $this->Html->link(
                $this->Pretty->iconAdd($item->name . " " . _("Payroll Item")),
                ['action' => 'addtoshow', $item->id],
                ['escape' => false, 'class' => 'btn btn-success btn-sm']
            ); ?>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $worked_paid = 0;
            $worked_owed = 0;

            foreach ( $payPadmin as $pitem ) {
                if ( $pitem->show_id == $item->id ) {
                    if ( $pitem->is_paid ) { 
                        $worked_paid = $pitem->totalwork;
                    } else {
                        $worked_owed = $pitem->totalwork;
                    }
                }
            }
        ?>
        <p><?= __("{0}{2}{1} taking place at {0}{3}{1} and ending on {0}{4}{1}", [
            "<strong>",
            "</strong>",
            $item->name,
            $item->location,
            $item->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC')
        ]); ?></p>
        <table class="table table-condensed">
            <tbody>
                <tr class="danger <?= ($worked_owed>0?"bold":"") ?>">
                    <td><?= __("Total Owed Hours") ?></td>
                    <td class='text-right'><?= number_format($worked_owed, 2) ?></td>
                </tr>            
                <tr class="success">
                    <td><?= __("Total Paid Hours") ?></td>
                    <td class='text-right'><?= number_format($worked_paid, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php endforeach; ?>
</div>

<?php if ( isset($showsAdmin) && !empty($showsAdmin) ): ?>
    <h3><?= __("Other Shows"); ?></h3>
    <p><?= __("These are the other open shows in the system.") ?></p>

    <div class="row">
    <?php $rowcount = 0; ?>
    <?php foreach ( $showsAdmin as $item ): ?>
    <?php if ( $rowcount == 2 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
    <div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?= $item->name ?>
                <div class="btn-group">
                <?= $this->Html->link(
                    $this->Pretty->iconView($item->name . " " . __("Payroll")),
                    ['action' => 'viewbyshow', $item->id],
                    ['escape' => false, 'class' => 'btn btn-default btn-sm']
                ) ?>
                <?= $this->Html->link(
                    $this->Pretty->iconUnpaid($item->name),
                    ['action' => 'unpaidbyshow', $item->id],
                    ['escape' => false, 'class' => 'btn btn-default btn-sm']
                ) ?>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <?php
                $worked_paid = 0;
                $worked_owed = 0;

                foreach ( $payAdmin as $pitem ) {
                    if ( $pitem->show_id == $item->id ) {
                        if ( $pitem->is_paid ) { 
                            $worked_paid = $pitem->totalwork;
                        } else {
                            $worked_owed = $pitem->totalwork;
                        }
                    }
                }
            ?>
            <p><?= __("{0}{2}{1} taking place at {0}{3}{1} and ending on {0}{4}{1}", [
                "<strong>",
                "</strong>",
                $item->name,
                $item->location,
                $item->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC')
            ]); ?></p>
            <table class="table table-condensed">
                <tbody>
                    <tr class="danger <?= ($worked_owed>0?"bold":"") ?>">
                        <td><?= __("Total Owed Hours") ?></td>
                        <td class='text-right'><?= number_format($worked_owed, 2) ?></td>
                    </tr>            
                    <tr class="success">
                        <td><?= __("Total Paid Hours") ?></td>
                        <td class='text-right'><?= number_format($worked_paid, 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->Pretty->helpMeStart('View Budgets'); ?>
<p><?= __("This display shows the payroll reports of the shows you have access, along with the current amount of hours paid out and still owed."); ?></p>
<p><?= __("The display includes the following categories - note that if you are a payroll admin on a show you also get paid on, a show may appear in more than one listing.") ?></p>
<?= $this->Html->nestedList([
    "<strong>Your Payroll Shows</strong>: Shows that you get paid on, you can add hours for yourself.",
    "<strong>Your Administrated Shows</strong>: Shows that you are a payroll administrator of, you can add hours for anyone who is paid on this show.",
    "<strong>Other Shows</strong>: Shows that you are neither paid on, or the payroll administrator of. This is only shown for system administrators, and you may only view the payroll record."
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<p>For each show, you will see up to three buttons:</p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('plus', 'success', __('Plus Button'), __('Add payroll expense to show')),
        $this->Pretty->helpButton('usd', 'default', __('Money Button'), __('View UNPAID hours in show')),
        $this->Pretty->helpButton('eye-open', 'default', __('Eye Button'), __('View detailed payroll report for show'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>

<?= $this->Pretty->helpMeEnd(); ?>
