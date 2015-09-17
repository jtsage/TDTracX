<div class="shows view large-10 medium-9 columns">
    <h3>
        <?= h($user->first) . " " . h($user->last) . _("'s Payroll Expenditure") ?>
        <?= $this->Html->link(
                $this->Pretty->iconDL(
                    $user->first . " " . $user->last . _('&#39;s Payroll Report')
                ),
                ['action' => 'viewbyusercsv', $user->id],
                ['escape' => false]
            ); ?>
        <?= $this->Form->postLink(
            $this->Pretty->iconMark($user->first . " " . $user->last),
            ['action' => 'markuserpaid', $user->id],
            ['escape' => false, 'confirm' => __('Are you sure you want to mark ALL paid for {0}?', $user->first . " " . $user->last)]);
        ?>
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
            if ( $item->showname <> $lastuser ) {
                if ( $subtotal > 0 ) {
                    echo "<tr class='success'><td colspan='4'><strong>";
                    echo __('User Sub-Total') . ": " . $lastuser;
                    echo "</td><td class='text-right'>";
                    echo number_format($subtotal,2);
                    echo "</td><td></td><td></td></tr>";    
                }
                echo "<tr class='info'><td colspan='7'><strong>";
                echo __('Show') . ": " . $item->showname;
                if ( ! $item->activeshow ) {
                    echo "<strong> [" . _('closed') . "]</strong>";
                }
                echo "</td></tr>";
                $subtotal = 0;
                $lastuser = $item->showname;
            }

            echo "<tr".(( !$item->is_paid ) ? " title='"._('Unpaid')."'":"")."><td>";
            echo $item->date_worked->i18nFormat('EEE, MMM dd, yyyy', 'UTC');
            echo "</td><td>" . $item->notes;
            echo "</td><td>" . $item->start_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC');
            echo "</td><td>" . $item->end_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC');
            echo "</td><td class='text-right'>" . number_format($item->worked, 2);
            echo "</td><td class='text-center'>";
            if ( !$item->is_paid ) {
                echo $this->Form->postLink(
                    $this->Pretty->iconMark($item->notes),
                    ['action' => 'markpaid', $item->id],
                    ['escape' => false, 'confirm' => __('Are you sure you want to mark paid # {0}?', $item->id)]);
                echo " ";
            }
            echo $this->Bool->prefYes($item->is_paid);
            echo "</td><td class='text-center'>";
            echo $this->Html->link(
                $this->Pretty->iconEdit($item->notes),
                ['action' => 'edit', $item->id],
                ['escape' => false]);

            echo $this->Form->postLink(
                $this->Pretty->iconDelete($item->notes),
                ['action' => 'delete', $item->id],
                ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $item->id)]);
            echo "</td></tr>";

            $subtotal += $item->worked;
            $total += $item->worked;
        }
        echo "<tr class='success'><td colspan='4'><strong>";
        echo __('Show Sub-Total') . ": " . $lastuser;
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


<?= $this->Pretty->helpMeStart('View User Payroll Report'); ?>
<p>This display shows the payroll report for the specified user, broken down by show</p>
<p>After the user name, you will see the following button:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> <strong>Download Button</strong>: Download a comma seperated (csv) file of the payroll report for offline printing or editing.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <strong>Check Button</strong>: Mark ALL this user's payroll records paid.</li>
</ul>

<p>For each entry, you may see these three buttons:</p>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <strong>Check Button</strong>: Mark the payroll record paid.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <strong>Pencil Button</strong>: Edit the payroll record.</li>

    <li class="list-group-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> <strong>Trash Button</strong>: Remove the payroll record.</li>
</ul>

<?= $this->Pretty->helpMeEnd(); ?>