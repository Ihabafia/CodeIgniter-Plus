<div class="row">
	<div class="col-md-12">

		<table  id="quotationsList" class="table table-striped table-bordered table-hover smaller" cellspacing="0" width="100%">
			<thead>
				<tr class="primary">
					<th><?php echo t('username');?></th>
					<th><?php echo t('index_fname_th');?></th>
					<th><?php echo t('index_lname_th');?></th>
					<th><?php echo t('index_email_th');?></th>
					<th><?php echo t('index_groups_th');?></th>
					<th><?php echo t('index_status_th');?></th>
					<th><?php echo t('index_action_th');?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user): if($user->id == 1) continue; ?>
				<tr>
					<td><?php echo $user->username;?></td>
					<td><?php echo $user->first_name;?></td>
					<td><?php echo $user->last_name;?></td>
					<td><?php echo $user->email;?></td>
					<td><?php echo humanize($user->group_name); ?></td>
					<td><?php echo ($user->group_name != 'administrator')?
						(($user->active) ? anchor("auth/deactivate/".$user->id, icon(), titleAlt('Deactivate')) : anchor("auth/activate/". $user->id, icon('danger'), titleAlt('Activate'))):'';?></td>
					<td><?php echo anchor("auth/edit/".$user->id, t('edit')) ;?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<div class="col-md-12">
		<?php echo (Modules::run('role/has_role', 'create_users')) ? anchor('auth/edit', t('index_create_user_link')) : ''; ?>
		<?php echo (Modules::run('role/has_role', 'create_users') && Modules::run('role/has_role', 'create_group'))? ' | ' : ''; ?>
		<?php echo (Modules::run('role/has_role', 'create_group')) ? anchor('auth/create_group', t('index_create_group_link')) : ''; ?>
	</div>
</div>
