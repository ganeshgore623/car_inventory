<?php

$num_columns	= 9;
$can_delete	= $this->auth->has_permission('Add_Model.Content.Delete');
$can_edit		= $this->auth->has_permission('Add_Model.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('add_model_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped' id="myTable">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('add_model_field_manufacturer_name'); ?></th>
					<th><?php echo lang('add_model_field_model'); ?></th>
					<th><?php echo lang('add_model_field_color'); ?></th>
					<th><?php echo lang('add_model_field_manufacturing_year'); ?></th>
					<th><?php echo lang('add_model_field_registration_number'); ?></th>
					<th><?php echo lang('add_model_field_note'); ?></th>
					<th><?php echo lang('add_model_column_deleted'); ?></th>
					<th><?php echo lang('add_model_column_created'); ?></th>
					<th><?php echo lang('add_model_column_modified'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('add_model_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->model_id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/add_model/edit/' . $record->model_id, '<span class="icon-pencil"></span> ' .  $record->manufacturer); ?></td>
				<?php else : ?>
					<td><?php e($record->manufacturer); ?></td>
				<?php endif; ?>
					<td><?php e($record->model); ?></td>
					<td><?php e($record->color); ?></td>
					<td><?php e($record->manufacturing_year); ?></td>
					<td><?php e($record->registration_number); ?></td>
					<td><?php e($record->note); ?></td>
					<td><?php echo $record->deleted > 0 ? lang('add_model_true') : lang('add_model_false'); ?></td>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->modified_on); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('add_model_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>