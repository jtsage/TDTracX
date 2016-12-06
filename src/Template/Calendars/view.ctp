<h3>
    <?= h($show->name) ?>
    <div class="btn-group">
    <?php if ( $opsok ) { echo $this->Html->link(
        $this->Pretty->iconAdd($show->name . " " . __("Event Item")),
        ['action' => 'add', $show->id],
        ['escape' => false, 'class' => 'btn btn-success btn-sm']
    ); } ?>
    </div>
</h3>

<div class="text-center"><h3>
    <?php
        echo $this->Html->link(
            $this->Pretty->makeIcon(__("Previous"), "arrow-circle-left", __("Month")),
            ['action' => 'view', $show->id, $prev[0], $prev[1]],
            ['escape' => false, 'class' => 'btn btn-default btn-sm']
        ); 
        echo " " . $month . " " . $year . " ";
        echo $this->Html->link(
            $this->Pretty->makeIcon(__("Next"), "arrow-circle-right", __("Month")),
            ['action' => 'view', $show->id, $next[0], $next[1]],
            ['escape' => false, 'class' => 'btn btn-default btn-sm']
        ); 
    ?>
</h3></div>

<table class="table table-bordered">
    <thead>
        <?= $this->Html->tableHeaders([
            [__("Sunday")    => ["class" => "text-center", "style" => "width:14.28%"]],
            [__("Monday")    => ["class" => "text-center", "style" => "width:14.28%"]],
            [__("Tuesday")   => ["class" => "text-center", "style" => "width:14.28%"]],
            [__("Wednesday") => ["class" => "text-center", "style" => "width:14.28%"]],
            [__("Thursday")  => ["class" => "text-center", "style" => "width:14.28%"]],
            [__("Friday")    => ["class" => "text-center", "style" => "width:14.28%"]],
            [__("Saturday")  => ["class" => "text-center", "style" => "width:14.28%"]],
        ]); ?>
    </thead>
    <tbody>

<?php 
    $colCount = 0;
    $currentDate = 1;
    $foundFirst = false;
    $foundLast = false;

    echo "<tr style='height: 90px;'>\n";
    while ( $colCount < 7 || !$foundLast ) {
        echo "  <td style='padding-left:0; padding-right:0;'>";
        if ( !$foundLast && ( $foundFirst || $colCount == $first_day_of_week) ) {
            $foundFirst = true;
            echo "<table style='width:100%'>";
            echo "<tr><td width:20%'></td><td style='width:60%'></td><td class='text-center'>" . $currentDate . "</td></tr>";
            echo "<tr><td colspan='3' style='font-size:40%'>&nbsp;</td></tr>";
            foreach ( $big_event[$currentDate] as $this_event ) {
                echo "<tr style='border-top: 1px #ccc solid; border-bottom: 1px #ccc solid;'>";
                echo "<td class='text-center' style='vertical-align: middle; font-size: 11px'>" . ($this_event['all_day']?"ALL":$this_event['start_time']->i18nFormat("H:mm", 'UTC')) . "</td>";
                echo "<td style='vertical-align:middle'><div style='padding: .2em; font-size: 12px; text-overflow: ellipsis'><a data-toggle=\"modal\" data-target=\"#event_". $this_event['id'] ."\">" . $this_event['title'] . "</a></div></td>";
                echo "<td class='text-center' style='vertical-align: middle; font-size: 11px'>" . ($this_event['all_day']?"DAY":$this_event['end_time']->i18nFormat("H:mm", 'UTC')) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            $currentDate++;
        } else { echo "&nbsp;"; }
        $colCount++;
        if ( $currentDate > $last_day_num ) { $foundLast = true; }
        echo "</td>\n";
        if ( $colCount == 7 && !$foundLast ) { echo "</tr>\n<tr style='height: 90px;'>\n"; $colCount = 0; }
    }
    echo "</tr>";
?>

    </tbody>
</table>

<?php foreach ( $big_event as $days_event ) : ?>
<?php foreach ( $days_event as $this_event ) : ?>
    <div class="modal fade" id="event_<?= $this_event['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?= $this_event['title'] ?></h4>
          </div>
          <div class="modal-body">
            <p><?= $this_event['note'] ?></p>
            <table class="table">
                <tr><th>Category</th><td><?= $this_event['category'] ?></td></tr>
                <tr><th>Begin / End Times</th><td>
                    <?php 
                        if ( $this_event['all_day'] ) { echo "ALL DAY"; }
                        else { 
                            echo $this_event['start_time']->i18nFormat("H:mm", 'UTC') . " / " . $this_event['end_time']->i18nFormat("H:mm", 'UTC');
                        }
                    ?>
                </td></tr>
                <tr><th>Created / Edited Dates</th><td>
                    <?php 
                        echo $this_event['created_at']->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT], 'UTC');
                        echo " / ";
                        echo $this_event['updated_at']->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT], 'UTC');
                    ?>
                </td></tr>
            </table>
          </div>
          <div class="modal-footer"><div class="btn-group">
            <a class="btn btn-default btn-sm" href="/calendars/edit/<?= $this_event['id'] ?>"><?= $this->Pretty->iconEdit($this_event['title']) ?> Edit</a>
            <?= ( $opsok ? $this->Form->postLink(
                    $this->Pretty->iconDelete($this_event['title']) . 'Delete',
                    ['action' => 'delete', $this_event['id']],
                    ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $this_event['id']), 'class' => 'btn btn-danger btn-sm' ] 
                ) : "") ?>
            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
          </div></div>
        </div>
      </div>
    </div>

<?php endforeach; ?>
<?php endforeach; ?>

<?= $this->Pretty->helpMeStart(__('View Calendars')); ?>
<p><?= _("This display shows the calendars of the shows you have access to.") ?></p>
<p><?= _("Additionally, if you are a system administrator, you can view the calendars from closed (inactive) shows.") ?></p>
<?= $this->Pretty->helpMeEnd(); ?>