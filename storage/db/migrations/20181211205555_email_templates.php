<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class EmailTemplates extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('email_templates', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'encoding' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci', 'comment' => '', 'row_format' => 'Dynamic']);
        $table->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])
            ->addColumn('users_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'id'])
            ->addColumn('companies_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'users_id'])
            ->addColumn('apps_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'companies_id'])
            ->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => 'utf8mb4_unicode_ci', 'encoding' => 'utf8mb4', 'after' => 'apps_id'])
            ->addColumn('template', 'text', ['null' => false, 'limit' => MysqlAdapter::TEXT_LONG, 'collation' => 'utf8mb4_unicode_ci', 'encoding' => 'utf8mb4', 'after' => 'name'])
            ->addColumn('created_at', 'datetime', ['null' => false, 'after' => 'template'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'after' => 'created_at'])
            ->addColumn('is_deleted', 'integer', ['null' => false, 'default' => '0', 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'updated_at'])
            ->create();

        $table = $this->table('email_templates_variables', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'encoding' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci', 'comment' => '', 'row_format' => 'Dynamic']);
        $table->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])
                ->addColumn('companies_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'id'])
                ->addColumn('apps_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'companies_id'])
                ->addColumn('system_modules_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'apps_id'])
                ->addColumn('users_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'system_modules_id'])
                ->addColumn('email_templates_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 11, 'after' => 'users_id'])
                ->addColumn('name', 'string', ['null' => false, 'limit' => 64, 'collation' => 'utf8mb4_unicode_ci', 'encoding' => 'utf8mb4', 'after' => 'email_templates_id'])
                ->addColumn('value', 'string', ['null' => false, 'limit' => 64, 'collation' => 'utf8mb4_unicode_ci', 'encoding' => 'utf8mb4', 'after' => 'name'])
                ->addColumn('created_at', 'datetime', ['null' => false, 'after' => 'value'])
                ->addColumn('updated_at', 'datetime', ['null' => true, 'after' => 'created_at'])
                ->addColumn('is_deleted', 'integer', ['null' => false, 'default' => '0', 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'updated_at'])
                ->create();
    }
}
