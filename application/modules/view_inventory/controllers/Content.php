<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'View_inventory.Content.Create';
    protected $permissionDelete = 'View_inventory.Content.Delete';
    protected $permissionEdit   = 'View_inventory.Content.Edit';
    protected $permissionView   = 'View_inventory.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('view_inventory/view_inventory_model');
        $this->lang->load('view_inventory');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            Assets::add_css('jquery-ui-timepicker.css');
            Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('view_inventory', 'view_inventory.js');
    }

    /**
     * Display a list of View Inventory data.
     *
     * @return void
     */
    public function index($offset = 0)
    {
        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->view_inventory_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('view_inventory_delete_success'), 'success');
                } else {
                    Template::set_message(lang('view_inventory_delete_failure') . $this->view_inventory_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/view_inventory/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->view_inventory_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->view_inventory_model->limit($limit, $offset);
        $this->view_inventory_model->join('bf_add_manufacturer','bf_add_manufacturer.manufacturer_id = bf_add_model.manufacturer','left');
        $records = $this->view_inventory_model->find_all();
        //dump($records);
        Template::set('records', $records);
        $this->view_inventory_model->join('bf_add_manufacturer','bf_add_manufacturer.manufacturer_id = bf_add_model.manufacturer','left');
        $records_count = $this->view_inventory_model->view_inventory_count();
        Template::set('records_count', $records_count); 
        //dump($records_count);exit;       
    Template::set('toolbar_title', lang('view_inventory_manage'));

        Template::render();
    }
    

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_view_inventory($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['model_id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->view_inventory_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->view_inventory_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['manufacturing_year']	= $this->input->post('manufacturing_year') ? $this->input->post('manufacturing_year') : '0000-00-00';
		$data['created_on']	= $this->input->post('created_on') ? $this->input->post('created_on') : '0000-00-00 00:00:00';
		$data['modified_on']	= $this->input->post('modified_on') ? $this->input->post('modified_on') : '0000-00-00 00:00:00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->view_inventory_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->view_inventory_model->update($id, $data);
        }

        return $return;
    }
}