<?php defined('BASEPATH') || exit('No direct script access allowed');

class View_inventory_model extends BF_Model
{
    protected $table_name	= 'add_model';
	protected $key			= 'model_id';
	protected $date_format	= 'datetime';

	protected $log_user 	= true;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= true;

    protected $deleted_field     = 'deleted';
    protected $deleted_by_field  = 'deleted_by';

	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'manufacturer_name',
			'label' => 'lang:view_inventory_field_manufacturer_name',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'model',
			'label' => 'lang:view_inventory_field_model',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'color',
			'label' => 'lang:view_inventory_field_color',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'manufacturing_year',
			'label' => 'lang:view_inventory_field_manufacturing_year',
			'rules' => '',
		),
		array(
			'field' => 'registration_number',
			'label' => 'lang:view_inventory_field_registration_number',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'note',
			'label' => 'lang:view_inventory_field_note',
			'rules' => '',
		),
		array(
			'field' => 'upload_img',
			'label' => 'lang:view_inventory_field_upload_img',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'deleted',
			'label' => 'lang:view_inventory_field_deleted',
			'rules' => 'max_length[1]',
		),
		array(
			'field' => 'deleted_by',
			'label' => 'lang:view_inventory_field_deleted_by',
			'rules' => 'max_length[20]',
		),
		array(
			'field' => 'created_on',
			'label' => 'lang:view_inventory_field_created_on',
			'rules' => '',
		),
		array(
			'field' => 'created_by',
			'label' => 'lang:view_inventory_field_created_by',
			'rules' => 'max_length[20]',
		),
		array(
			'field' => 'modified_on',
			'label' => 'lang:view_inventory_field_modified_on',
			'rules' => '',
		),
		array(
			'field' => 'modified_by',
			'label' => 'lang:view_inventory_field_modified_by',
			'rules' => 'max_length[20]',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function view_inventory_count(){
    	$sql ="select model_id,manufacturer,model,count(model) as count_value from bf_add_model  GROUP BY `model`";     	
    	return $this->db->query($sql)->result();
    }
}