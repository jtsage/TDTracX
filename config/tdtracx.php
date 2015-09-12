<?php
return [ 
	'Datasources' => [
        'default' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'persistent' => false,
			'host' => 'mysql.jtsage.com',
			'username' => 'tdtracx',
			'password' => 'xcartdt',
			'database' => 'tdtracx',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
        ],
    ],
];
?>
