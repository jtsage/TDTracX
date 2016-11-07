<?php
use Migrations\AbstractMigration;

class Zerozeroten extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public $autoId = false;

    public function change()
    {

        $this->table('tasks')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('created_by', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('assigned_to', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('show_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('due', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('priority', 'integer', [
                'default' => 1,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('category', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('note', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('task_accepted', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('task_done', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => '1970-01-01 05:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'assigned_to',
                ]
            )
            ->addIndex(
                [
                    'created_by',
                ]
            )
            ->addIndex(
                [
                    'show_id',
                ]
            )
            ->create();
        $this->table('tasks')
             ->addForeignKey(
                 'assigned_to',
                 'users',
                 'id',
                 [
                     'update' => 'CASCADE',
                     'delete' => 'SET_NULL'
                 ]
             )
             ->addForeignKey(
                 'created_by',
                 'users',
                 'id',
                 [
                     'update' => 'CASCADE',
                     'delete' => 'SET_NULL'
                 ]
             )
             ->addForeignKey(
                 'show_id',
                 'shows',
                 'id',
                 [
                     'update' => 'CASCADE',
                     'delete' => 'CASCADE'
                 ]
             )
             ->update();
        $table = $this->table('show_user_perms')
            ->addColumn('is_task_admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_task_user', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])->update();
    }
}

