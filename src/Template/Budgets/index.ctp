<h3><?= __("Show Budgets"); ?></h3>

<?php foreach ($shows as $show): ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $show->name ?>
            <div class="btn-group">
            <?= $this->Html->link(
                $this->Pretty->iconView($show->name . " " . _("Budget")),
                ['action' => 'view', $show->id],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
            <?= $this->Html->link(
                $this->Pretty->iconAdd($show->name . " " . _("Budget Item")),
                ['action' => 'add', $show->id],
                ['escape' => false, 'class' => 'btn btn-success btn-sm']
            ) ?>
            </div>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $total = 0;
            $each = [];
            foreach ( $budget as $budgetitem ) {
                if ( $budgetitem->show_id == $show->id ) {
                    $total += $budgetitem->total;
                    $each[] = ['name' => $budgetitem->category, 'total' => $budgetitem->total];
                }
            }
        ?>
        <p>
            <strong><?= $show->name ?></strong>
            <?= _(" taking place at ") ?>
            <strong><?=$show->location ?></strong>
            <?= _(" ending on ") ?>
            <strong><?= $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></strong>
        </p>

        <table class="table table-condensed">
            <thead>
                <tr class="info"><th><?= _('Category') ?></th><th class='text-right'><?= _('Amount') ?></th></tr>
            </thead>
            
            <tbody>
            <?php
                foreach ( $each as $row ) {
                    echo "<tr><td>{$row['name']}</td><td class='text-right'>" . $this->Number->currency($row['total']) . "</td></tr>";
                }
            ?>
                <tr class="success">
                    <td><strong><?= __("Total Expenditure") ?></strong></td>
                    <td class='text-right'><strong><?= $this->Number->currency($total); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>

<?php
    // Admin Only, show inactive //
    if ( isset($inactshows) && !empty($inactshows)) { 
        echo "<h3>" . __("Closed Show Budgets") . "</h3>";
    }
?>
<?php foreach ($inactshows as $show): ?>

<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $show->name ?>
            <?= $this->Html->link(
                $this->Pretty->iconView($show->name . " " . _("Budget")),
                ['action' => 'view', $show->id],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $total = 0;
            $each = [];
            foreach ( $budget as $budgetitem ) {
                if ( $budgetitem->show_id == $show->id ) {
                    $total += $budgetitem->total;
                    $each[] = ['name' => $budgetitem->category, 'total' => $budgetitem->total];
                }
            }
        ?>
        <p>
            <strong><?= $show->name ?></strong>
            <?= _(" taking place at ") ?>
            <strong><?=$show->location ?></strong>
            <?= _(" ending on ") ?>
            <strong><?= $show->end_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC'); ?></strong>
        </p>

        <table class="table table-condensed">
            <thead>
                <tr class="info"><th><?= _('Category') ?></th><th class='text-right'><?= _('Amount') ?></th></tr>
            </thead>
            
            <tbody>
            <?php
                foreach ( $each as $row ) {
                    echo "<tr><td>{$row['name']}</td><td class='text-right'>" . $this->Number->currency($row['total']) . "</td></tr>";
                }
            ?>
                <tr class="success">
                    <td><strong><?= __("Total Expenditure") ?></strong></td>
                    <td class='text-right'><strong><?= $this->Number->currency($total); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>

<?= $this->Pretty->helpMeStart('View Budgets'); ?>
<p><?= _("This display shows the budgets of the shows you have access, along with the current expenditure broken down by budget category.") ?></p>
<p><?= _("For each show, you will see two buttons:") ?></p>
<?= $this->Html->nestedList([
        $this->Pretty->helpButton('eye-open', 'default', _('Person Button'), _('View detailed expense report for show')),
        $this->Pretty->helpButton('plus', 'success', _('Plus Button'), _('Add Expense to show'))
    ], ['class' => 'list-group'], ['class' => 'list-group-item']
); ?>
<p><?= _("Additionally, if you are a system administrator, you can view the budgets from closed (inactive) shows.") ?></p>
<?= $this->Pretty->helpMeEnd(); ?>