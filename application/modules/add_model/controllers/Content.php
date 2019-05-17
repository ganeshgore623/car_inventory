<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'Add_model.Content.Create';
    protected $permissionDelete = 'Add_model.Content.Delete';
    protected $permissionEdit   = 'Add_model.Content.Edit';
    protected $permissionView   = 'Add_model.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('add_model/add_model_model');
        $this->load->model('add_manufacturer/add_manufacturer_model');
        $this->lang->load('add_model');
        $this->target_path = "uploads/";
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('add_model', 'add_model.js');
        Assets::add_module_css('add_model', 'add_model.css');
    }

    /**
     * Display a list of Add Model data.
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
                    $deleted = $this->add_model_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('add_model_delete_success'), 'success');
                } else {
                    Template::set_message(lang('add_model_delete_failure') . $this->add_model_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/add_model/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->add_model_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->add_model_model->limit($limit, $offset);
        
        $records = $this->add_model_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('add_model_manage'));

        Template::render();
    }
    
    /**
     * Create a Add Model object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {

            $j = 0; //Variable for indexing uploaded image 
            $_POST['upload_imgs']=array();
            $target_path = $this->target_path; //Declaring Path for uploaded images
            for ($i = 0; $i < count($_FILES['upload_img']['name']); $i++) {//loop to get individual element from the array

                $validextensions = array("jpeg","png","jpg");  //Extensions which are allowed
                $ext = explode('.', basename($_FILES['upload_img']['name'][$i]));//explode file name from dot(.) 
                $file_extension = end($ext); //store extensions in the variable
                $filename = str_replace(' ', '_', $_FILES['upload_img']['name'][$i]);
                $new_file_name="emp".time()."_".$filename;
                $targetpath = $target_path . $new_file_name;//set the target path with a new name of image
                $j = $j + 1;//increment the number of uploaded images according to the files in array       
              
                  if (($_FILES["upload_img"]["size"][$i] < MAX_UPLOAD_SIZE) //Approx. 100kb files can be uploaded.
                        && in_array($file_extension, $validextensions)) {
                    if (move_uploaded_file($_FILES['upload_img']['tmp_name'][$i], $targetpath)) {//if file moved to uploads folder
                        //echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
                        array_push($_POST['upload_imgs'],$new_file_name);
                    } else {//if file was not moved.
                        //echo $j. ').<span id="error">please try again!.</span><br/><br/>';
                    }
                } else {//if file size and file type was incorrect.
                    //echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
                }
            }

            $_POST['upload_img']=implode(",",$_POST['upload_imgs']);

            if ($insert_id = $this->save_add_model()) {
                log_activity($this->auth->user_id(), lang('add_model_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'add_model');
                Template::set_message(lang('add_model_create_success'), 'success');

                redirect(SITE_AREA . '/content/add_model');
            }

            // Not validation error
            if ( ! empty($this->add_model_model->error)) {
                Template::set_message(lang('add_model_create_failure') . $this->add_model_model->error, 'error');
            }
        }
        $manufacturer_list = $this->add_manufacturer_model->manufacturer_list();
        Template::set('manufacturer_list', $manufacturer_list);

        Template::set('toolbar_title', lang('add_model_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Add Model data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('add_model_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/add_model');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_add_model('update', $id)) {
                log_activity($this->auth->user_id(), lang('add_model_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'add_model');
                Template::set_message(lang('add_model_edit_success'), 'success');
                redirect(SITE_AREA . '/content/add_model');
            }

            // Not validation error
            if ( ! empty($this->add_model_model->error)) {
                Template::set_message(lang('add_model_edit_failure') . $this->add_model_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->add_model_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('add_model_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'add_model');
                Template::set_message(lang('add_model_delete_success'), 'success');

                redirect(SITE_AREA . '/content/add_model');
            }

            Template::set_message(lang('add_model_delete_failure') . $this->add_model_model->error, 'error');
        }

        $manufacturer_list = $this->add_manufacturer_model->manufacturer_list();
        Template::set('manufacturer_list', $manufacturer_list);
        
        Template::set('add_model', $this->add_model_model->find($id));

        Template::set('toolbar_title', lang('add_model_edit_heading'));
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
    private function save_add_model($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['model_id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->add_model_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->add_model_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['manufacturing_year']	= $this->input->post('manufacturing_year') ? $this->input->post('manufacturing_year') : '0000-00-00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->add_model_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->add_model_model->update($id, $data);
        }

        return $return;
    }
}