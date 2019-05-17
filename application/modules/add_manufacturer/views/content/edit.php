<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('add_manufacturer_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($add_manufacturer->manufacturer_id) ? $add_manufacturer->manufacturer_id : '';

?>
<div class='admin-box'>
    <h3>Add Manufacturer</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('manufacturer_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('add_manufacturer_field_manufacturer_name') . lang('bf_form_label_required'), 'manufacturer_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='manufacturer_name' type='text' required='required' name='manufacturer_name' maxlength='255' value="<?php echo set_value('manufacturer_name', isset($add_manufacturer->manufacturer_name) ? $add_manufacturer->manufacturer_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('manufacturer_name'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('add_manufacturer_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/add_manufacturer', lang('add_manufacturer_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Add_Manufacturer.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('add_manufacturer_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('add_manufacturer_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>