<div class="shows view large-10 medium-9 columns">
    <h3>
        <?= h($show->name) . _(" Payroll Expenditure") ?>
        <?= ( isset($show_add) && $show_add ) ? $this->Html->link(
                $this->Pretty->iconAdd($show->name . " " . _("Payroll Item")),
                ['action' => 'addtoshow', $show->id],
                ['escape' => false]
            ) : "" ?>
    </h3>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?= _("Date Worked") ?></th>
            <th><?= _("Note") ?></th>
            <th><?= _("Start Time") ?></th>
            <th><?= _("End Time") ?></th>
            <th class="text-right"><?= _("Hours Worked") ?></th>
            <th class="text-center"><?= _("Is Paid?") ?></th>
            <th class="text-center"><?= _("Actions") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 

        $total = 0;
        $subtotal = 0;
        $lastuser = "";

        foreach ( $payrolls as $item ) {
            if ( $item->fullname <> $lastuser ) {
                if ( $subtotal > 0 ) {
                    echo "<tr class='success'><td colspan='4'><strong>";
                    echo __('User Sub-Total') . ": " . $lastuser;
                    echo "</td><td class='text-right'>";
                    echo number_format($subtotal,2);
                    echo "</td><td></td><td></td></tr>";    
                }
                echo "<tr class='info'><td colspan='7'><strong>";
                echo __('User') . ": " . $item->fullname;
                echo "</td></tr>";
                $subtotal = 0;
                $lastuser = $item->fullname;
            }

            echo "<tr".(( !$item->is_paid ) ? " title='"._('Unpaid')."'":"")."><td>";
            echo $item->date_worked->i18nFormat('EEE, MMM dd, yyyy', 'UTC');
            echo "</td><td>" . $item->notes;
            echo "</td><td>" . $item->start_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC');
            echo "</td><td>" . $item->end_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC');
            echo "</td><td class='text-right'>" . number_format($item->worked, 2);
            echo "</td><td class='text-center'>";
            if ( isset($show_add) && $show_add && !$item->is_paid ) {
                echo $this->Form->postLink(
                    $this->Pretty->iconMark($item->notes),
                    ['action' => 'markpaid', $item->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to mark paid # {0}?', $item->id)]);
                echo " ";
            }
            echo $this->Bool->prefYes($item->is_paid);
            echo "</td><td class='text-center'>";
            
            if ( (isset($show_add) && $show_add) || !$item->is_paid ) {
                echo $this->Html->link(
                    $this->Pretty->iconEdit($item->notes),
                    ['action' => 'edit', $item->id],
                    ['escape' => false]);

                echo $this->Form->postLink(
                    $this->Pretty->iconDelete($item->notes),
                    ['action' => 'delete', $item->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $item->id)]);
            }
            echo "</td></tr>";

            $subtotal += $item->worked;
            $total += $item->worked;
        }
        echo "<tr class='success'><td colspan='4'><strong>";
        echo __('User Sub-Total') . ": " . $lastuser;
        echo "</td><td class='text-right'>";
        echo number_format($subtotal,2);
        echo "</td><td></td><td></td></tr>";

        echo "<tr class='danger'><td colspan='4'><strong>";
        echo __('Total Hours');
        echo "</td><td class='text-right'>";
        echo number_format($total,2);
        echo "</td><td></td><td></td></tr>";

        ?>
    </tbody>
</table>
