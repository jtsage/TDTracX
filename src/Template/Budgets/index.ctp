<h3><?= __("Show Budgets"); ?></h3>

<?php foreach ($shows as $show): ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $show->name ?>
            <?= $this->Html->link(
                $this->Pretty->iconView($show->name . " " . _("Budget")),
                ['action' => 'view', $show->id],
                ['escape' => false]
            ) ?>
            <?= $this->Html->link(
                $this->Pretty->iconAdd($show->name . " " . _("Budget Item")),
                ['action' => 'add', $show->id],
                ['escape' => false]
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
                ['escape' => false]
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