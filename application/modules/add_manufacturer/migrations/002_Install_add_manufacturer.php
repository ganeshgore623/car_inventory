<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_add_manufacturer extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'add_manufacturer';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'manufacturer_id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'manufacturer_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('manufacturer_id', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}