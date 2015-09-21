
<h3><?= __("Payroll By User"); ?></h3>

<div class="row">
<?php $rowcount = 0; ?>
<?php foreach ( $ulist as $id => $name ): ?>
<?php if ( $rowcount == 3 ) { echo "</div><div class='row'>"; $rowcount=0; } $rowcount++; ?>
<div class="col-md-4">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $name ?>
            <?= $this->Html->link(
                $this->Pretty->iconView(__("Payroll for ") . $name),
                ['action' => 'viewbyuser', $id],
                ['escape' => false, 'class' => 'btn btn-default btn-sm']
            ) ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php
            $worked_paid = 0;
            $worked_owed = 0;

            foreach ( $buddy as $pitem ) {
                if ( $pitem->user_id == $id ) {
                    if ( $pitem->is_paid ) { 
                        $worked_paid = $pitem->totalwork;
                    } else {
                        $worked_owed = $pitem->totalwork;
                    }
                }
            }
        ?>
        <table class="table table-condensed">
            <tbody>
                <tr class="danger <?= ($worked_owed>0?"bold":"") ?>">
                    <td><?= __("Owed Hours") ?></td>
                    <td class='text-right'><?= number_format($worked_owed, 2) ?></td>
                </tr>            
                <tr class="success">
                    <td><?= __("Paid Hours") ?></td>
                    <td class='text-right'><?= number_format($worked_paid, 2) ?></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
</div>
<?php endforeach; ?>
</div>


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
