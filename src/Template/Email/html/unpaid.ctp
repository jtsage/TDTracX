<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<h3>This contains the current list of users needing payed.</h3>
<p>Please visit the database to set these hours as paid.</p>

<table border="1" style="width: 100%">
<thead>
<?= $this->Html->tableHeaders($headers); ?>
</thead>
<tbody>
<?= $this->Html->tableCells($tabledata); ?>
</tbody>
</table>
