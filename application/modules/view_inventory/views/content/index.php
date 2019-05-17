<?php

$num_columns	= 13;
$can_delete	= $this->auth->has_permission('View_Inventory.Content.Delete');
$can_edit		= $this->auth->has_permission('View_Inventory.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);
$has_records_count	= isset($records_count) && is_array($records_count) && count($records_count);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('view_inventory_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped' id="myTable">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('view_inventory_field_manufacturer_name'); ?></th>
					<th><?php echo lang('view_inventory_field_model'); ?></th>
					<th><?php echo lang('view_inventory_field_color'); ?></th>
					<th><?php echo lang('view_inventory_field_manufacturing_year'); ?></th>
					<th><?php echo lang('view_inventory_field_registration_number'); ?></th>
					<th><?php echo lang('view_inventory_field_note'); ?></th>
					<th><?php echo lang('view_inventory_field_deleted'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete1'); ?>" onclick="return confirm('<?php e(js_escape(lang('view_inventory_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/content/view_inventory/edit/' . $record->model_id, '<span class="icon-pencil"></span> ' .  $record->manufacturer_name); ?></td>
				<?php else : ?>
					<td><?php e($record->manufacturer_name); ?></td>
				<?php endif; ?>
					<td><?php e($record->model); ?></td>
					<td><?php e($record->color); ?></td>
					<td><?php e($record->manufacturing_year); ?></td>
					<td><?php e($record->registration_number); ?></td>
					<td><?php e($record->note); ?></td>
					<td><?php echo $record->deleted > 0 ? lang('view_inventory_true') : lang('view_inventory_false'); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('view_inventory_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>

<div class='admin-box'>
	<h3>
		<?php echo lang('view_inventory_area_title_'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped' id="myTable">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records_count) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					<th><?php echo lang('view_inventory_field_model'); ?></th>
					<th><?php echo lang('view_inventory_field_count'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records_count) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete1'); ?>" onclick="return confirm('<?php e(js_escape(lang('view_inventory_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records_count) :
					foreach ($records_count as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->model_id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/view_inventory/edit/' . $record->model_id, '<span class="icon-pencil"></span> '); ?></td>
				<?php else : ?>
				<?php endif; ?>
					<td><?php e($record->model); ?></td>
					<td><?php e($record->count_value); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('view_inventory_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>