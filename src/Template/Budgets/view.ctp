
<div class="budgets view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) ?>

        <?php if ( $opsok ) { echo $this->Html->link(
            $this->Pretty->iconAdd($show->name . " " . _("Budget Item")),
            ['action' => 'add', $show->id],
            ['escape' => false]
        ); } ?>
        <?= $this->Html->link(
            $this->Pretty->iconDL($show->name . " " . _("Budget")),
            ['action' => 'viewcsv', $show->id],
            ['escape' => false]
        ) ?>
    </h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Date') ?></th>
                <th><?= __('Vendor') ?></th>
                <th><?= __('Description') ?></th>
                <th class='text-right'><?= __('Price') ?></th>
                <th class='text-center'><?= __('Actions') ?></th>
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
                        echo "<tr class='success'><td colspan='3'><strong>";
                        echo __('Category Sub-Total') . ": " . $lastcat;
                        echo "</td><td class='text-right'>";
                        echo $this->Number->currency($subtotal);
                        echo "</td><td></td></tr>";    
                    }
                    echo "<tr class='info'><td colspan='5'><strong>";
                    echo __('Category') . ": " . $item->category;
                    echo "</td></tr>";
                    $subtotal = 0;
                    $lastcat = $item->category;
                }
                echo "<tr><td>";
                echo $item->date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE], 'UTC');
                echo "</td><td>" . $item->vendor;
                echo "</td><td>" . $item->description;
                echo "</td><td class='text-right'>" . $this->Number->currency($item->price);
                echo "</td><td class='text-center'>";
                if ( $opsok ) {
                    echo $this->Html->link(
                        $this->Pretty->iconEdit($item->description),
                        ['action' => 'edit', $item->id],
                        ['escape' => false]);

                    echo $this->Form->postLink(
                        $this->Pretty->iconDelete($item->description),
                        ['action' => 'delete', $item->id],
                        ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $item->id)]);
                }
                echo "</td></tr>";

                $subtotal += $item->price;
                $total += $item->price;
            }
            echo "<tr class='success'><td colspan='3'><strong>";
            echo __('Category Sub-Total') . ": " . $lastcat;
            echo "</td><td class='text-right'>";
            echo $this->Number->currency($subtotal);
            echo "</td><td></td></tr>";

            echo "<tr class='danger'><td colspan='3'><strong>";
            echo __('Total Expenditure');
            echo "</td><td class='text-right'>";
            echo $this->Number->currency($total);
            echo "</td><td></td></tr>";
        ?>
        </tbody>
    </table>
</div>
