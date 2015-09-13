
<div class="budgets view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) ?>
        <?= $this->Html->link(
            $this->Pretty->iconAdd($show->name . " " . _("Budget Item")),
            ['action' => 'add', $show->id],
            ['escape' => false]
        ) ?>
    </h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Date') ?></th>
                <th><?= __('Vendor') ?></th>
                <th><?= __('Price') ?></th>
                <th><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $lastcat = "";
            $total = 0;
            $subtotal = 0;

            foreach ( $budgets as $item ) {
                if ( $item->category <> $lastcat ) {
                    if ( $subtotal > 0 ) {
                        echo "<tr class='success'><td colspan='2'><strong>";
                        echo __('Category Sub-Total') . ": " . $lastcat;
                        echo "</td><td class='text-right'>";
                        echo $this->Number->currency($subtotal);
                        echo "</td><td></td></tr>";    
                    }
                    echo "<tr class='info'><td colspan='4'><strong>";
                    echo __('Category') . ": " . $item->category;
                    echo "</td></tr>";
                    $subtotal = 0;
                    $lastcat = $item->category;
                }
                echo "<tr><td>";
                echo $item->date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC');
                echo "</td><td>" . $item->vendor;
                echo "</td><td class='text-right'>" . $this->Number->currency($item->price);
                echo "</td><td>";
                echo "</td></tr>";

                $subtotal += $item->price;
                $total += $item->price;
            }
            echo "<tr class='success'><td colspan='2'><strong>";
            echo __('Category Sub-Total') . ": " . $lastcat;
            echo "</td><td class='text-right'>";
            echo $this->Number->currency($subtotal);
            echo "</td><td></td></tr>";

            echo "<tr class='danger'><td colspan='2'><strong>";
            echo __('Total Expenditure');
            echo "</td><td class='text-right'>";
            echo $this->Number->currency($total);
            echo "</td><td></td></tr>";
        ?>
        </tbody>
    </table>
    <?php /*
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
    </div>*/ ?>
</div>
