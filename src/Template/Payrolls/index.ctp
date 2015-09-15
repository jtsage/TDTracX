
<h3><?= __("Your Payroll Shows"); ?></h3>
<p><?= __("These are shows you are on the payroll for.") ?></p>

<?php foreach ( $showsPaid as $item ): ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $item->name ?>
            <?= $this->Html->link(
                $this->Pretty->iconView(__("Your Payroll for ") . $item->name),
                ['action' => 'viewbyuser', $item->id],
                ['escape' => false]
            ) ?>
            <?= $this->Html->link(
                $this->Pretty->iconAdd($item->name . " " . _("Payroll Item")),
                ['action' => 'addtoself', $item->id],
                ['escape' => false]
            ) ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $worked_paid = 0;
            $worked_owed = 0;

            foreach ( $payPaid as $pitem ) {
                if ( $pitem->show_id == $item->id ) {
                    if ( $pitem->is_paid ) { $worked_paid = $pitem->totalwork; }
                    if ( ! $pitem->is_paid ) { $worked_owed = $pitem->totalwork; }
                }
            }
        ?>
        <p>
            <strong><?= $item->name ?></strong>
            <?= _(" taking place at ") ?>
            <strong><?= $item->location ?></strong>
            <?= _(" and ending on ") ?>
            <strong><?= $item->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></strong>
        </p>
        <table class="table table-condensed">
            <tbody>
                <tr class="danger">
                    <td><strong><?= __("Your Owed Hours") ?></strong></td>
                    <td class='text-right'><strong><?= number_format($worked_owed, 2) ?></strong></td>
                </tr>            
                <tr class="success">
                    <td><strong><?= __("Your Paid Hours") ?></strong></td>
                    <td class='text-right'><strong><?= number_format($worked_paid, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<?php endforeach; ?>


<h3><?= __("Your Administrated Shows"); ?></h3>
<p><?= __("These are shows you are the payroll administrator for.") ?></p>

<?php foreach ( $showsPadmin as $item ): ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $item->name ?>
            <?= $this->Html->link(
                $this->Pretty->iconView($item->name . " " . __("Payroll")),
                ['action' => 'viewbyshow', $item->id],
                ['escape' => false]
            ) ?>
            <?= $this->Html->link(
                $this->Pretty->iconAdd($item->name . " " . _("Payroll Item")),
                ['action' => 'addtoshow', $item->id],
                ['escape' => false]
            ) ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $worked_paid = 0;
            $worked_owed = 0;

            foreach ( $payPadmin as $pitem ) {
                if ( $pitem->show_id == $item->id ) {
                    if ( $pitem->is_paid ) { $worked_paid = $pitem->totalwork; }
                    if ( ! $pitem->is_paid ) { $worked_owed = $pitem->totalwork; }
                }
            }
        ?>
        <p>
            <strong><?= $item->name ?></strong>
            <?= _(" taking place at ") ?>
            <strong><?= $item->location ?></strong>
            <?= _(" and ending on ") ?>
            <strong><?= $item->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></strong>
        </p>
        <table class="table table-condensed">
            <tbody>
                <tr class="danger">
                    <td><strong><?= __("Total Owed Hours") ?></strong></td>
                    <td class='text-right'><strong><?= number_format($worked_owed, 2) ?></strong></td>
                </tr>            
                <tr class="success">
                    <td><strong><?= __("Total Paid Hours") ?></strong></td>
                    <td class='text-right'><strong><?= number_format($worked_paid, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>


<?php if ( isset($showsAdmin) && !empty($showsAdmin) ): ?>
    <h3><?= __("Other Shows"); ?></h3>
    <p><?= __("These are the other open shows in the system.") ?></p>

    <?php foreach ( $showsAdmin as $item ): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?= $item->name ?>
                <?= $this->Html->link(
                    $this->Pretty->iconView($item->name . " " . __("Payroll")),
                    ['action' => 'viewbyshow', $item->id],
                    ['escape' => false]
                ) ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php
                $worked_paid = 0;
                $worked_owed = 0;

                foreach ( $payAdmin as $pitem ) {
                    if ( $pitem->show_id == $item->id ) {
                        if ( $pitem->is_paid ) { $worked_paid = $pitem->totalwork; }
                        if ( ! $pitem->is_paid ) { $worked_owed = $pitem->totalwork; }
                    }
                }
            ?>
            <p>
                <strong><?= $item->name ?></strong>
                <?= _(" taking place at ") ?>
                <strong><?= $item->location ?></strong>
                <?= _(" and ending on ") ?>
                <strong><?= $item->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></strong>
            </p>
            <table class="table table-condensed">
                <tbody>
                    <tr class="danger">
                        <td><strong><?= __("Total Owed Hours") ?></strong></td>
                        <td class='text-right'><strong><?= number_format($worked_owed, 2) ?></strong></td>
                    </tr>                    
                    <tr class="success">
                        <td><strong><?= __("Total Paid Hours") ?></strong></td>
                        <td class='text-right'><strong><?= number_format($worked_paid, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->Pretty->helpMeStart('View Budgets'); ?>
<p>This display shows the payroll reports of the shows you have access, along with the current amount of hours paid out and still owed.</p>
<p>The display includes the following categories - note that if you are a payroll admin on a show you also get paid on, a show may appear in more than one listing.</p>
<ul class="list-group">
    <li class="list-group-item"><strong>Your Payroll Shows</strong>: Shows that you get paid on, you can add hours for yourself.</li>
    <li class="list-group-item"><strong>Your Administrated Shows</strong>: Shows that you are a payroll administrator of, you can add hours for anyone who is paid on this show.</li>
    <li class="list-group-item"><strong>Other Shows</strong>: Shows that you are neither paid on, or the payroll administrator of. This is only shown for system administrators, and you may only view the payroll record.</li>
</ul>
<p>For each show, you will see two buttons:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <strong>Plus Button</strong>: Add an payroll item to the show.</li>
    <li class="list-group-item"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <strong>Eye Button</strong>: View a detailed payroll report.</li>
</ul>
<?= $this->Pretty->helpMeEnd(); ?>
