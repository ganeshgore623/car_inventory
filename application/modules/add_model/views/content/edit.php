<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('add_model_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($add_model->model_id) ? $add_model->model_id : '';

?>
<div class='admin-box'>
    <h3>Add Model</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            <div class="row-fluid">    
            <div class="control-group<?php echo form_error('model') ? ' error' : ''; ?>">
                <?php echo form_label(lang('add_model_field_model') . lang('bf_form_label_required'), 'model', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='model' type='text' required='required' name='model' maxlength='255' value="<?php echo set_value('model', isset($add_model->model) ? $add_model->model : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('model'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    11 => 11,
                );
                echo form_dropdown(array('name' => 'manufacturer_name', 'required' => 'required'), $manufacturer_list, set_value('manufacturer_name', isset($add_model->manufacturer_name) ? $add_model->manufacturer_name : ''), lang('add_model_field_manufacturer_name') . lang('bf_form_label_required'));
            ?>
            </div>

            <div class="row-fluid">
            <div class="control-group<?php echo form_error('color') ? ' error' : ''; ?>">
                <?php echo form_label(lang('add_model_field_color'), 'color', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='color' type='text' name='color' maxlength='255' value="<?php echo set_value('color', isset($add_model->color) ? $add_model->color : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('color'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('manufacturing_year') ? ' error' : ''; ?>">
                <?php echo form_label(lang('add_model_field_manufacturing_year'), 'manufacturing_year', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='manufacturing_year' type='text' name='manufacturing_year' maxlength='255' value="<?php echo set_value('manufacturing_year', isset($add_model->manufacturing_year) ? $add_model->manufacturing_year : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('manufacturing_year'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('registration_number') ? ' error' : ''; ?>">
                <?php echo form_label(lang('add_model_field_registration_number'), 'registration_number', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='registration_number' type='text' name='registration_number' maxlength='255' value="<?php echo set_value('registration_number', isset($add_model->registration_number) ? $add_model->registration_number : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('registration_number'); ?></span>
                </div>
            </div>
            </div>
            <div class="row-fluid">
            <div class="control-group<?php echo form_error('note') ? ' error' : ''; ?>">
                <?php echo form_label(lang('add_model_field_note'), 'note', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'note', 'id' => 'note', 'rows' => '5', 'cols' => '80', 'value' => set_value('note', isset($add_model->note) ? $add_model->note : ''))); ?>
                    <span class='help-inline'><?php echo form_error('note'); ?></span>
                </div>
            </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('add_model_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/add_model', lang('add_model_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Add_Model.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('add_model_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('add_model_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>