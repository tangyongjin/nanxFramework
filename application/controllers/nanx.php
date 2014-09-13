<?php

class Nanx extends CI_Controller {
	function actionCfg() {
		$this->load->model('MSystempara');
		$win_size_height          = $this->MSystempara->getCfgItem('WIN_SIZE_HEIGHT');
		$win_size_width           = $this->MSystempara->getCfgItem('WIN_SIZE_WIDTH');
		$win_size_width_operation = $this->MSystempara->getCfgItem('WIN_SIZE_WIDTH_OPERATION');

		$cfg = array(
			'upload_pic' => array(
				'successmsg' => 'success_upload_file',
				'tbused'     => null,
				'dbcmdtype'  => 'upload_pic',
				'paracfg'    => array()
			),

			'backup_db' => array(
				'successmsg' => 'success_backup',
				'tbused'     => null,
				'dbcmdtype'  => 'backup',
				'paracfg'    => array('table_name' => 'table_name', 'backup_name' => 'backup_name')),

			'backup_system' => array(
				'successmsg' => 'success_backup',
				'tbused'     => null,
				'dbcmdtype'  => 'backup_system',
				'paracfg'    => array('backup_name' => 'backup_name')),

			'add_trigger_group' => array(
				'successmsg' => 'success_add_trigger_group',
				'tbused'     => 'nanx_biz_column_trigger_group',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array('table_name' => 'table_name', 'backup_name' => 'backup_name')),

			'create_base_table' => array(
				'successmsg' => 'success_create_biz_table',
				'tbused'     => 'nanx_biz_tables',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array('table_screen_name' => 'table_screen_name', 'table_name' =>
					'table_name')),

			'delete_biz_table' => array(
				'successmsg' => 'success_delete_biz_table',
				'tbused'     => 'nanx_biz_tables',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'rename_biz_table' => array(
				'successmsg' => 'success_rename_biz_table',
				'tbused'     => 'nanx_biz_tables',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('table_screen_name' => 'table_screen_name'),
				'wherecfg'                                => array('pid' => 'pid')),

			'rename_activity' => array(
				'successmsg' => 'success_rename_activity',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('grid_title' => 'grid_title'),
				'wherecfg'                         => array('pid' => 'pid')),

			'set_act_size' => array(
				'successmsg' => 'success_set_window_size',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'update',
				'paracfg'    => array(
					'win_size_width'           => 'win_size_width',
					'win_size_height'          => 'win_size_height',
					'win_size_width_operation' => 'win_size_width_operation'),
				'wherecfg'                  => array('pid' => 'pid')),

			'set_activity_base_table' => array(
				'successmsg' => 'success_set_base_table',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('base_table' => 'base_table'),
				'wherecfg'                         => array('pid' => 'pid')),

			'set_forbidden_col' => array(
				'successmsg' => 'success_set_forbidden_col',
				'tbused'     => 'nanx_activity_forbidden_field',
				'dbcmdtype'  => 'delete_and_insert',
				'batch_cols' => array('field'),
				'batch_type' => 'comma',
				'wherecfg'   => array('activity_code' => 'hostby'),
				'paracfg'                             => array('activity_code' => 'hostby', 'field' => 'field')),

			'set_form_layout' => array(
				'successmsg' => 'success_set_form_layout',
				'tbused'     => 'nanx_activity_biz_layout',
				'dbcmdtype'  => 'delete_and_insert',
				'paracfg'    => array('extradata' => 'extradata'),
				'wherecfg'                        => array('activity_code' => 'hostby')),

			'connect_user' => array(
				'successmsg' => 'success_connect_user',
				'tbused'     => 'nanx_who_is_who',
				'dbcmdtype'  => 'delete_and_insert',
				'paracfg'    => array('extradata' => 'extradata'),
				'when_get_where'                  => 'later',
				'wherecfg'                        => array('inner_table' => 'inner_table', 'inner_table_pid' => 'inner_table_pid')),

			'user_sms' => array(
				'successmsg' => 'success_send_sms',
				'tbused'     => 'nanx_sms',
				'dbcmdtype'  => 'insert',
				'timestamp'  => 'sendtime',
				'paracfg'    => array(
					'title'    => 'title',
					'msg'      => 'msg',
					'sender'   => 'sender',
					'receiver' => 'nodevalue')),

			'p2p_sms' => array(
				'successmsg' => 'success_p2p_sms',
				'tbused'     => 'nanx_sms',
				'dbcmdtype'  => 'insert',
				'batch_cols' => array('receiver'),
				'batch_type' => 'array',
				'timestamp'  => 'sendtime',
				'paracfg'    => array(
					'sender'   => 'nodevalue',
					'title'    => 'title',
					'msg'      => 'msg',
					'receiver' => 'sms_receivers')),

			'role_sms' => array(
				'successmsg' => 'success_send_sms_to_role',
				'tbused'     => 'nanx_sms',
				'dbcmdtype'  => 'insert',
				'batch_cols' => array('receiver'),
				'batch_type' => 'array',
				'timestamp'  => 'sendtime',
				'paracfg'    => array(
					'sender'   => 'sender',
					'title'    => 'title',
					'msg'      => 'msg',
					'receiver' => 'sms_receivers')),

			'group_sms' => array(
				'successmsg' => 'success_group_sms',
				'tbused'     => 'nanx_sms',
				'dbcmdtype'  => 'insert',
				'batch_cols' => array('receiver'),
				'batch_type' => 'array',
				'timestamp'  => 'sendtime',
				'paracfg'    => array(
					'sender'   => 'sender',
					'title'    => 'title',
					'msg'      => 'msg',
					'receiver' => 'sms_receivers')),

			'delete_activity' => array(
				'successmsg' => 'success_delete_activity',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('activity_code' => 'nodevalue'),
				'tbused'                              => array(
					'nanx_user_role_privilege',
					'nanx_activity',
					'nanx_activity_batch_btns',
					'nanx_activity_biz_layout',
					'nanx_activity_a2a_btns',
					'nanx_activity_curd_cfg',
					'nanx_activity_forbidden_field',
					'nanx_activity_pid_order',
					'nanx_activity_js_btns')),

			'delete_dropdown_item' => array(
				'successmsg' => 'success_delete_dropdown_item',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('group_id' => 'group_id'),
				'tbused'                         => array('nanx_biz_column_follow_cfg', 'nanx_biz_column_trigger_group')),

			'add_activity' => array(
				'successmsg' => 'success_add_activity',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array(
					'activity_code' => 'activity_code',
					'grid_title'    => 'grid_title',
					'base_table'    => 'base_table'),
				'default'        => array(
					'win_size_height'          => $win_size_height,
					'win_size_width'           => $win_size_width,
					'win_size_width_operation' => $win_size_width_operation,
					'activity_type'            => 'table',
					'pic_url'                  => 'act_common.png',
					'data_url'                 => 'curd/listData')),

			'add_js_activity' => array(
				'successmsg'        => 'success_add_js_activity',
				'tbused'            => 'nanx_activity',
				'dbcmdtype'         => 'insert',
				'upload_file_field' => 'extra_js',
				'paracfg'           => array(
					'activity_code'     => 'activity_code',
					'grid_title'        => 'grid_title',
					'js_function_point' => 'js_function_point',
					'extra_js'          => 'extra_js'),
				'default'            => array(
					'activity_type' => 'js',
					'pic_url'       => 'act_js.png',
					'data_url'      => 'curd/listData')),

			'add_service_activity' => array(
				'successmsg' => 'success_add_service_activity',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array(
					'activity_code' => 'activity_code',
					'grid_title'    => 'grid_title',
					'service_url'   => 'service_url',
					'memo'          => 'memo'),
				'default'        => array(
					'activity_type' => 'service',
					'pic_url'       => 'act_service.png',
					'data_url'      => 'curd/listData')),

			'add_sql_activity' => array(
				'successmsg' => 'success_add_sql_activity',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array(
					'activity_code' => 'activity_code',
					'grid_title'    => 'grid_title',
					'sql'           => 'sql'),
				'default'        => array(
					'win_size_height'          => $win_size_height,
					'win_size_width'           => $win_size_width,
					'win_size_width_operation' => $win_size_width_operation,
					'activity_type'            => 'sql',
					'pic_url'                  => 'act_sql.png',
					'data_url'                 => 'curd/listData')),

			'add_public_item' => array(
				'successmsg' => 'success_add_public_item',
				'tbused'     => 'nanx_activity_field_public_display_cfg',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array('field_e' => 'input_0', 'field_c' => 'input_1')),

			'add_user' => array(
				'successmsg' => 'success_add_user',
				'tbused'     => 'nanx_user',
				'dbcmdtype'  => 'insert',
				'salt_field' => 'password',
				'paracfg'    => array('user' => 'user', 'staff_name' => 'staff_name'),
				'default'                    => array('password' => '12345678', 'active' => 'Y')),

			'add_notify_rule' => array(
				'successmsg' => 'success_add_notify_rule',
				'tbused'     => 'nanx_activity_nofity',
				'dbcmdtype'  => 'insert',
				'batch_cols' => array('action', 'receiver_role_list'),
				'batch_type' => 'array',
				'paracfg'    => array(
					'activity_code'      => 'activity_code',
					'rule_name'          => 'rule_name',
					'receiver_role_list' => 'receiver_role_list',
					'action'             => 'action')),

			'delete_notify_rule' => array(
				'successmsg' => 'success_delete_notify_rule',
				'tbused'     => 'nanx_activity_nofity',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('rule_name' => 'nodevalue')),

			'delete_trigger_group' => array(
				'successmsg' => 'success_delete_trigger_group',
				'tbused'     => 'nanx_biz_column_trigger_group',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('group_id' => 'group_id', 'base_table' => 'hostby')),

			'edit_notify_rule' => array(
				'tbused'     => 'nanx_activity_nofity',
				'successmsg' => 'success_edit_notify_rule',
				'dbcmdtype'  => 'delete_and_insert',
				'batch_cols' => array('action', 'receiver_role_list'),
				'batch_type' => 'array',
				'wherecfg'   => array('rule_name' => 'nodevalue'),
				'paracfg'                         => array(
					'activity_code'      => 'activity_code',
					'rule_name'          => 'rule_name',
					'receiver_role_list' => 'receiver_role_list',
					'action'             => 'action')),

			'reset_pwd' => array(
				'successmsg' => 'success_reset_pwd',
				'tbused'     => 'nanx_user',
				'dbcmdtype'  => 'update',
				'salt_field' => 'password',
				'paracfg'    => array('password' => 'password'),
				'wherecfg'                       => array('user' => 'nodevalue')),

			'set_logo' => array(
				'successmsg' => 'success_set_logo',
				'tbused'     => 'nanx_system_cfg',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('config_value' => 'input_0'),
				'wherecfg'                           => array('config_key' => 'key')),

			'delete_public_item' => array(
				'successmsg' => 'success_delete_public_item',
				'tbused'     => 'nanx_activity_field_public_display_cfg',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'nodevalue')),

			'delete_user' => array(
				'successmsg' => 'success_delete_user',
				'tbused'     => 'nanx_user',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'set_biz_table_ref' => array(
				'successmsg' => 'success_set_biz_table_ref',
				'tbused'     => 'nanx_biz_tables',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('table_name' => 'selected_table'),
				'wherecfg'                         => array('pid' => 'pid')),

			'rename_role' => array(
				'successmsg' => 'success_rename_role',
				'tbused'     => 'nanx_user_role',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('role_name' => 'role_name'),
				'wherecfg'                        => array('pid' => 'pid')),

			'add_role' => array(
				'successmsg' => 'success_add_role',
				'tbused'     => 'nanx_user_role',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array('role_code' => 'role_code', 'role_name' => 'role_name')),

			'delete_role' => array(
				'successmsg' => 'success_delete_role',
				'tbused'     => 'nanx_user_role',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'remove_activity' => array(
				'successmsg' => 'success_remove_activity',
				'tbused'     => 'nanx_user_role_privilege',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'reest_pwd' => array(
				'successmsg' => 'success_reest_pwd',
				'tbused'     => 'nanx_user',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('password' => 'input_0'),
				'wherecfg'                       => array('pid' => 'pid')),

			'rename_a2a_btn' => array(
				'successmsg' => 'success_rename_btn',
				'tbused'     => 'nanx_activity_a2a_btns',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('btn_name' => 'input_0'),
				'wherecfg'                       => array('pid' => 'pid')),

			'remove_a2a_btn' => array(
				'successmsg' => 'success_remove_btn',
				'tbused'     => 'nanx_activity_a2a_btns',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'rename_batch_btn' => array(
				'successmsg' => 'success_rename_btn',
				'tbused'     => 'nanx_activity_batch_btns',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('btn_name' => 'input_0'),
				'wherecfg'                       => array('pid' => 'pid')),

			'remove_batch_btn' => array(
				'successmsg' => 'success_remove_btn',
				'tbused'     => 'nanx_activity_batch_btns',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'rename_js_btn' => array(
				'successmsg' => 'success_rename_btn',
				'tbused'     => 'nanx_activity_js_btns',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('btn_name' => 'input_0'),
				'wherecfg'                       => array('pid' => 'pid')),

			'remove_js_btn' => array(
				'successmsg' => 'success_remove_btn',
				'tbused'     => 'nanx_activity_js_btns',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'remove_user' => array(
				'successmsg' => 'success_remove_user',
				'tbused'     => 'nanx_user_role_assign',
				'dbcmdtype'  => 'delete',
				'paracfg'    => array('pid' => 'pid')),

			'add_a2a_button' => array(
				'successmsg' => 'success_add_button',
				'tbused'     => 'nanx_activity_a2a_btns',
				'dbcmdtype'  => 'insert',
				'paracfg'    => array(
					'activity_code'           => 'hostby',
					'btn_name'                => 'btn_name',
					'field_for_main_activity' => 'field_for_main_activity',
					'field_for_sub_activity'  => 'field_for_sub_activity',
					'activity_for_btn'        => 'activity_for_btn')),

			'add_js_button' => array(
				'successmsg'        => 'success_add_button',
				'tbused'            => 'nanx_activity_js_btns',
				'dbcmdtype'         => 'insert',
				'upload_file_field' => 'jsfile',
				'paracfg'           => array(
					'activity_code' => 'hostby',
					'btn_name'      => 'btn_name',
					'function_name' => 'function_name',
					'jsfile'        => 'jsfile')),

			'add_batch_update_btn' => array(
				'successmsg' => 'success_add_button',
				'tbused'     => 'nanx_activity_batch_btns',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('btn_name' => 'btn_name'),
				'wherecfg'                       => array('activity_code' => 'hostby', 'op_field' => 'op_field')),

			'set_filter_col' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_activity_a2a_btns',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('field_for_main_activity' => 'field_for_main_activity',
					'field_for_sub_activity'                       => 'field_for_sub_activity'),
				'wherecfg'                                      => array('pid' => 'pid')),

			'update_sql' => array(
				'successmsg' => 'success_update_sql',
				'tbused'     => 'nanx_activity',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('sql' => 'sql'),
				'wherecfg'                  => array('pid' => 'pid')),

			'set_service_para_col' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_activity_a2a_btns',
				'dbcmdtype'  => 'update',
				'paracfg'    => array('field_for_main_activity' => 'selected_value_nanxdropdown_1'),
				'wherecfg'                                      => array('pid' => 'pid')),

			'set_pid_order' => array(
				'successmsg' => 'success_set_pid_order',
				'tbused'     => 'nanx_activity_pid_order',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('pid_order' => 'pid_order'),
				'wherecfg'                        => array('activity_code' => 'hostby')),

			'set_display_text' => array(
				'successmsg' => 'success_rename_field',
				'tbused'     => 'nanx_activity_field_special_display_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('field_c' => 'field_c'),
				'wherecfg'                      => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'set_field_width' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_activity_field_special_display_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('field_width' => 'field_width'),
				'wherecfg'                          => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'set_field_default_value' => array(
				'successmsg' => 'success_set_field_default_value',
				'tbused'     => 'nanx_biz_column_editor_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array(
					'base_table' => 'hostby',
					'field_e'    => 'nodevalue',
					'default_v'  => 'f_def_fix'),
				'default'     => array('use_combo' => 1),
				'wherecfg'                         => array('field_e' => 'nodevalue', 'base_table' => 'hostby')),

			'set_biz_field_combo_resorce' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_biz_column_trigger_group',
				'dbcmdtype'  => 'delete_and_insert',
				'paracfg'    => array(
					'base_table'  => 'hostby',
					'field_e'     => 'field_e',
					'combo_table' => 'combo_table',
					'list_field'  => 'list_field',
					'group_id'    => 'group_id',
					'value_field' => 'value_field'),
				'default'      => array('level' => 1, 'group_type' => 'nogroup'),
				'wherecfg'                      => array('field_e' => 'field_e', 'base_table' => 'hostby')),

			'set_biz_field_combo_follow' => array(
				'successmsg' => 'success_set_follow',
				'tbused'     => 'nanx_biz_column_follow_cfg',
				'dbcmdtype'  => 'delete_and_insert',
				'paracfg'    => array(
					'base_table'              => 'hostby',
					'combo_table'             => 'combo_table',
					'field_e'                 => 'field_e',
					'group_id'                => 'group_id',
					'combo_table_value_field' => 'value_field'),
				'key_for_array_col_data'   => 'nanx_follow_cfg',
				'wherecfg'                 => array('combo_table' => 'combo_table', 'base_table' => 'hostby')),

			'set_show_as_pic' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_activity_field_special_display_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('show_as_pic' => 'show_as_pic'),
				'wherecfg'                          => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'set_to_me' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_biz_column_editor_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('is_produce_col' => 'is_produce_col', 'combo_table' => 'combo_table', 'list_field' => 'list_field',
					'value_field'                         => 'value_field'),
				'wherecfg'                             => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'set_use_html_editor' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_biz_column_editor_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('edit_as_html' => 'edit_as_html'),
				'wherecfg'                           => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'set_activity_curd' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_activity_curd_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array(
					'fn_add'    => 'fn_add',
					'fn_update' => 'fn_update',
					'fn_del'    => 'fn_del'),
				'wherecfg'   => array('activity_code' => 'nodevalue')),

			'set_upload_field' => array(
				'successmsg' => 'success_set',
				'tbused'     => 'nanx_biz_column_editor_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array('need_upload' => 'need_upload'),
				'wherecfg'                          => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'delete_col' => array(
				'successmsg' => 'success_delete_col',
				'dbcmdtype'  => 'delete_col',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array('dropcol' => 'nodevalue', 'usedtable' => 'hostby')),

			'rename_col' => array(
				'successmsg' => 'success_rename_col',
				'dbcmdtype'  => 'rename_col',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array(
					'usedtable'         => 'hostby',
					'orgincol'          => 'nodevalue',
					'newcolname'        => 'input_0',
					'column_definition' => 'column_definition')),

			'set_col_displayname' => array(
				'successmsg' => 'success_set_col_displayname',
				'tbused'     => 'nanx_activity_field_special_display_cfg',
				'dbcmdtype'  => 'update_or_insert',
				'paracfg'    => array(
					'base_table' => 'hostby',
					'field_e'    => 'nodevalue',
					'field_c'    => 'field_c'),
				'wherecfg'    => array('base_table' => 'hostby', 'field_e' => 'nodevalue')),

			'set_activity_pic' => array(
				'successmsg'        => 'success_set_activity_pic',
				'tbused'            => 'nanx_activity',
				'dbcmdtype'         => 'update',
				'upload_file_field' => 'file_anchor_4_pic',
				'paracfg'           => array('pic_url' => 'file_anchor_4_pic'),
				'wherecfg'                             => array('pid' => 'pid')),

			'truncate_table' => array(
				'successmsg' => 'success_truncate_table',
				'dbcmdtype'  => 'truncate_table',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array('usedtable' => 'usedtable'),
			),

			'rename_table' => array(
				'successmsg' => 'success_rename_table',
				'dbcmdtype'  => 'rename_table',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array('usedtable' => 'nodevalue', 'newtable' => 'input_0'),
			),

			'copy_table' => array(
				'successmsg' => 'success_duplicate_table',
				'dbcmdtype'  => 'copy_table',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array('usedtable' => 'nodevalue', 'newtable' => 'input_0'),
			),

			'set_col_order' => array(
				'successmsg' => 'success_reorder_col',
				'dbcmdtype'  => 'set_col_order',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array('nodevalue' => 'nodevalue', 'extradata' => 'extradata'),
			),

			'create_table_from_excel' => array(
				'successmsg' => 'success_create_table_from_excel',
				'tbused'     => null,
				'dbcmdtype'  => 'create_table_from_excel',
				'paracfg'    => array('table_name' => 'table_name', 'excel' => 'excel')),

			'restore_db' => array(
				'successmsg' => 'success_restore_database',
				'tbused'     => null,
				'dbcmdtype'  => 'restore_db',
				'paracfg'    => array('restore_file' => 'restore_file')),

			'update_js_content' => array(
				'successmsg' => 'success_update_js_content',
				'tbused'     => null,
				'dbcmdtype'  => 'update_js_content',
				'paracfg'    => array('js_content' => 'js_content', 'js_file' => 'js_file')),

			'create_table' => array(
				'successmsg' => 'success_create_table',
				'tbused'     => 'dependnextarray',
				'dbcmdtype'  => 'create_table',
				'paracfg'    => array(
					'base_table' => 'base_table',
					'DDL'        => 'DDL',
					'newtable'   => 'newtable')),

			'drop_table' => array(
				'successmsg' => 'success_drop_table',
				'dbcmdtype'  => 'drop_table',
				'tbused'     => 'dependnextarray',
				'paracfg'    => array('usedtable' => 'table'),
			),
			'null' => array());
		return $cfg;
	}

	function DndActionConfig() {
		$cfg = array(
			'dnd_set_activity_base_table' => array(
				'tbused'    => 'nanx_activity',
				'dbcmdtype' => 'update',
				'paracfg'   => array('base_table' => array('getFrom' => 'src', 'value' => 'value')),
				'wherecfg'                                           => array('pid' => array('getFrom' => 'target', 'value' => 'pid'))),

			'dnd_create_activity_via_base_table' => array(
				'tbused'    => 'nanx_activity',
				'dbcmdtype' => 'insert',
				'paracfg'   => array(
					'base_table' => array('getFrom' => 'src', 'value' => 'table'),
					'grid_title'                    => array(
						'getFrom'      => 'src',
						'function'     => 'generate_act_name',
						'value'        => 'text'),
					'activity_code' => array(
						'getFrom'  => 'src',
						'function' => 'generate_act_code',
						'value'    => 'table'),
					'pic_url'   => array('getFrom' => 'local', 'value' => 'act_common.png'),
					'activity_type'                => array('getFrom' => 'local', 'value' => 'table'),
					'win_size_height'                                 => array('getFrom' => 'local', 'value' => '662'),
					'win_size_width'                                                     => array('getFrom' => 'local', 'value' => '800'),
				)),

			'reset_raw_table' => array(
				'tbused'    => 'nanx_biz_tables',
				'dbcmdtype' => 'update',
				'paracfg'   => array('table_name' => array('getFrom' => 'src', 'value' => 'value')),
				'wherecfg'                                           => array('pid' => array('getFrom' => 'target', 'value' => 'pid'))),

			'reuse_button' => array(
				'tbused'    => 'nanx_activity_a2a_btns',
				'dbcmdtype' => 'insert',
				'paracfg'   => array(
					'activity_code'    => 'hostby',
					'btn_name'         => 'input_0',
					'activity_for_btn' => 'nanxdropdown_0')),

			'dnd_user_role_add_activity' => array(
				'tbused'    => 'nanx_user_role_privilege',
				'dbcmdtype' => 'insert',
				'paracfg'   => array('activity_code' => array('getFrom' => 'src', 'value' =>
						'value'), 'role_code'                                 => array('getFrom' => 'target', 'value' => 'value'))),

			'dnd_user_role_add_service_activity' => array(
				'tbused'    => 'nanx_user_role_privilege',
				'dbcmdtype' => 'insert',
				'paracfg'   => array('activity_code' => array('getFrom' => 'src', 'value' =>
						'value'), 'role_code'                                 => array('getFrom' => 'target', 'value' => 'value'))),

			'dnd_user_role_add_js_activity' => array(
				'tbused'    => 'nanx_user_role_privilege',
				'dbcmdtype' => 'insert',
				'paracfg'   => array('activity_code' => array('getFrom' => 'src', 'value' =>
						'value'), 'role_code'                                 => array('getFrom' => 'target', 'value' => 'value'))),

			'dnd_user_role_add_sql_activity' => array(
				'tbused'    => 'nanx_user_role_privilege',
				'dbcmdtype' => 'insert',
				'paracfg'   => array('activity_code' => array('getFrom' => 'src', 'value' =>
						'value'), 'role_code'                                 => array('getFrom' => 'target', 'value' => 'value'))),

			'dnd_user_role_add_html_activity' => array(
				'tbused'    => 'nanx_user_role_privilege',
				'dbcmdtype' => 'insert',
				'paracfg'   => array('activity_code' => array('getFrom' => 'src', 'value' =>
						'value'), 'role_code'                                 => array('getFrom' => 'target', 'value' => 'value'))),

			'add_user_to_role' => array(
				'tbused'    => 'nanx_user_role_assign',
				'dbcmdtype' => 'insert',
				'paracfg'   => array('user' => array('getFrom' => 'src', 'value' => 'value'),
					'role_code'                                   => array('getFrom' => 'target', 'value' => 'value'))));
		return $cfg;
	}

	function DnDSrcTargetCfg() {
		$cfg = array(
			'dnd_set_activity_base_table' => array('src' => 'biz_table', 'target' =>
				'activity'),

			'dnd_create_activity_via_base_table' => array('src' => 'biz_table', 'target' =>
				'activitys'),

			'reset_raw_table' => array('src' => 'table', 'target' => 'biz_table'),
			'reuse_button'                   => array('src' => 'button', 'target' => 'activity'),

			'dnd_user_role_add_activity' => array('src' => 'activity', 'target' =>
				'user_role_under_acls'),

			'dnd_user_role_add_service_activity' => array('src' => 'activity_service',
				'target'                                           => 'user_role_under_acls'),

			'dnd_user_role_add_js_activity' => array('src' => 'activity_js', 'target' =>
				'user_role_under_acls'),

			'dnd_user_role_add_sql_activity' => array('src' => 'activity_sql', 'target' =>
				'user_role_under_acls'),

			'dnd_user_role_add_html_activity' => array('src' => 'activity_html', 'target' =>
				'user_role_under_acls'),

			'add_user_to_role' => array('src' => 'user', 'target' => 'user_role'),
		);
		return $cfg;
	}

	function getRawTbnameByPid($pid) {
		$sql        = "select table_name from nanx_biz_tables  where pid=SHOULD_REPLACE";
		$sql        = str_replace('SHOULD_REPLACE', $pid, $sql);
		$rows       = $this->db->query($sql)->result_array();
		$raw_tbname = $rows[0]['table_name'];
		return $raw_tbname;
	}

	function index() {
		$data_get_post = (array ) json_decode(file_get_contents('php://input'));
		$data_recevied = (array ) $data_get_post['rawdata'];
		$opcode        = $data_recevied['opcode'];

		$opcode_arr = explode(",", $opcode);
		foreach ($opcode_arr as $key => $single_opcode) {
			$result = $this->processOpcode($data_recevied, $single_opcode);
		}

		echo $result;
		return;
	}

	function getFixedData($action_cfg, $data_received) {
		$opcode     = $action_cfg['opcode'];
		$data_fixed = $this->getDataArray($action_cfg, $data_received);

		if ($opcode == 'set_form_layout') {
			$data_fixed = $this->getFormLayoutData($data_received);
		}

		if ($opcode == 'connect_user') {
			$data_fixed = $this->getConnectionInfo($data_received);

			return array($data_fixed);

		}

		if ($opcode == 'add_trigger_group') {
			$data_fixed = $this->getTriggerGroupData($data_received);
		}

		if ($opcode == 'set_field_default_value') {
			$data_fixed = $this->getDefalultValue($data_received);
		}

		if ($opcode == 'set_to_me') {
			if (strlen($data_fixed[0]['combo_table']) == 0) {
				$data_fixed[0]['combo_table'] = 'nanx_user';
				$data_fixed[0]['list_field']  = 'staff_name';
				$data_fixed[0]['value_field'] = 'pid';
			}
		}

		return $data_fixed;
	}

	function getWhereCfg($action_cfg, $data_received) {
		if (array_key_exists('wherecfg', $action_cfg)) {
			$wherecfg = $action_cfg['wherecfg'];
			foreach ($wherecfg as $key => $refer_key) {
				$wherecfg[$key] = $data_received[$refer_key];
			}
			return $wherecfg;
		}
	}

	function processOpcode($data_received, $opcode) {
		$action_cfg = $this->actionCfg()[$opcode];
		$all_cfg    = $this->actionCfg();
		if (!$action_cfg) {
			$res = array(
				'success' => false,
				'opcode'  => $opcode,
				'msg'     => 'No such opcode',
				'errcode' => -1,
				'errmsg'  => 'No such opcode <br/> ');

			return json_encode($res);
		}

		$action_cfg['opcode'] = $opcode;

		$tbused     = $action_cfg['tbused'];
		$dbcmdtype  = $action_cfg['dbcmdtype'];
		$data_fixed = $this->getFixedData($action_cfg, $data_received);

		// getwhre config can be two types, now or later
		if (array_key_exists('when_get_where', $action_cfg) && $action_cfg['when_get_where'] == 'later') {
			$wherecfg = $this->getWhereCfg($action_cfg, $data_fixed[0]);
		} else {
			$wherecfg = $this->getWhereCfg($action_cfg, $data_received);
		}

		if ($dbcmdtype == 'insert') {
			if (count($data_fixed) > 0) {
				$this->db->insert_batch($tbused, $data_fixed);
			}
		}

		if ($dbcmdtype == 'delete') {
			if (!is_array($tbused)) {
				$tbused = array($tbused);
			}
			foreach ($tbused as $tb_to_del) {
				$this->db->delete($tb_to_del, $data_fixed[0]);
			}
		}

		if ($dbcmdtype == 'update') {
			$this->db->update($tbused, $data_fixed[0], $wherecfg);
			if ($opcode == 'set_activity_pic') {
				$this->load->model('MFile');
				$f = $this->MFile->getFilename4OS($data_fixed[0]['pic_url']);
				$this->MFile->writeThumb($f);
			}
		}

		if ($dbcmdtype == 'update_or_insert') {
			$this->db->update($tbused, $data_fixed[0], $wherecfg);
			$this->db->from($tbused)->where($wherecfg);
			if ($this->db->count_all_results() == 0) {
				$data = array_merge($data_fixed[0], $wherecfg);
				$this->db->insert($tbused, $data);
			} else {
				$this->db->update($tbused, $data_fixed[0], $wherecfg);
			}
		}

		if ($dbcmdtype == 'delete_and_insert') {

			$this->db->delete($tbused, $wherecfg);
			if (count($data_fixed) > 0) {
				$this->db->insert_batch($tbused, $data_fixed);
			}
		}

		if (in_array($dbcmdtype, array(
					'set_col_order',
					'truncate_table',
					'delete_col',
					'rename_col',
					'drop_table',
					'rename_table',
					'copy_table',
					'create_table'))) {
			$this->rdbms_action($dbcmdtype, $data_fixed);
		}

		if ($dbcmdtype == 'update_js_content') {
			$fname                = 'js/upload/' . $data_fixed[0]['js_file'];
			$content              = $data_fixed[0]['js_content'];
			$action_cfg['opcode'] = 'update_js_content';
			$this->load->model('MFile');
			$result = $this->MFile->write_os_file($action_cfg, $fname, $content);
			echo json_encode($result);
			return;
		}

		if ($dbcmdtype == 'backup') {
			$this->load->dbutil();
			$tbs      = $data_fixed[0]['table_name'];
			$tbs_back = explode(",", $tbs);
			if (count($tbs_back) == 1) {
				$tbs_back = $tbs_back[0];
			}
			$prefs = array(
				'tables' => $tbs_back,
				'ignore' => array(),
				'format'     => 'zip',
				'filename'   => null,
				'add_drop'   => true,
				'add_insert' => true,
				'newline'    => "\n");

			$fname  = "tmp/" . $data_fixed[0]['backup_name'] . "." . $prefs['format'];
			$backup = &$this->dbutil->backup($prefs);
			$this->load->model('MFile');
			$ret = $this->MFile->write_os_file($action_cfg, $fname, $backup);
			if ($ret['success']) {
				$ret['showdownload'] = true;
				$ret['fname']        = base_url() . $ret['fname'];
			}
			printjson_encode($ret, JSON_UNESCAPED_UNICODE);
			return;
		}

		if ($dbcmdtype == 'backup_system') {

			$fname = $data_fixed[0]['backup_name'] . ".zip";
			$this->load->model('MFile');

			$ret = $this->MFile->backupsystem($fname);
			if ($ret['success']) {
				$ret['showdownload'] = true;
				$ret['fname']        = base_url() . '/tmp/' . $ret['fname'];
			}
			printjson_encode($ret, JSON_UNESCAPED_UNICODE);
			return;
		}

		if ($dbcmdtype == 'create_table_from_excel') {
			$this->load->model('Mexcel');
			$table_name  = $data_fixed[0]['table_name'];
			$success_msg = $this->lang->line($action_cfg['successmsg']);
			$this->load->model('MFile');
			$upload_excel = $this->MFile->getUploadFileName($data_fixed[0]['excel']);
			$result       = $this->Mexcel->excel2table($table_name, "uploads/" . $upload_excel, $success_msg);
			return $result;
		}

		if ($dbcmdtype == 'restore_db') {
			$this->load->model('MFile');
			$zip_or_sql = $this->MFile->getUploadFileName($data_fixed[0]['restore_file']);
			$fname      = "uploads/" . $zip_or_sql;
			$file_ext   = $this->MFile->getFileType($fname);
			if ($file_ext == 'sql') {
				$sql = $fname;
			} else {
				$zip = new ZipArchive;
				$zip->open($fname);
				$zip->extractTo('tmp/');
				$unziped = $this->MFile->getFilenameInZip($fname);
				$sql     = "tmp/" . $unziped;
			}

			$this->load->helper('file');

			$backup    = read_file($sql);
			$sql_clean = '';
			foreach (explode("\n", $backup) as $line) {
				if (isset($line[0]) && $line[0] != "#") {
					$sql_clean .= $line . "\n";
				}
			}

			foreach (explode(";\n", $sql_clean) as $sql) {
				$sql = trim($sql);
				if ($sql) {
					$this->db->query($sql);
				}
			}
		}
		$operation_result = $this->sendDbResult($action_cfg);
		return $operation_result;
	}

	function getDataArray($actcfg, $data_received) {
		$data_fixed = $actcfg['paracfg'];

		if (array_key_exists('upload_file_field', $actcfg)) {
			$key   = $actcfg['upload_file_field'];
			$fname = $data_received[$key];
			$this->load->model('MFile');
			$os_file             = $this->MFile->getUploadFileName($fname);
			$data_received[$key] = $os_file;
		}

		foreach ($data_fixed as $key => $field) {
			if (array_key_exists($field, $data_received)) {
				$data_fixed[$key] = $data_received[$field];
			} else {
				if (array_key_exists('batch_cols', $actcfg) && (in_array($field, $actcfg['batch_cols']))) {
					if ($actcfg['batch_type'] == 'comma') {
						$data_fixed[$key] = '';
					} else {
						$data_fixed[$key] = array();
					}
				}
			}
		}

		if (array_key_exists('default', $actcfg)) {
			$data_fixed = array_merge($data_fixed, $actcfg['default']);
		}

		if (array_key_exists('salt_field', $actcfg)) {
			$salt_field              = $actcfg['salt_field'];
			$salt                    = substr(uniqid(rand()), -6);
			$pwd                     = $data_fixed[$salt_field];
			$pwd_with_salt           = md5(md5($pwd) . $salt);
			$data_fixed['salt']      = $salt;
			$data_fixed[$salt_field] = $pwd_with_salt;
		}

		if (array_key_exists('timestamp', $actcfg)) {
			$timestamp_field              = $actcfg['timestamp'];
			$now                          = date('Y-m-d h:i:s');
			$data_fixed[$timestamp_field] = $now;
		}

		if (array_key_exists('batch_cols', $actcfg)) {
			$matrix = array();
			foreach ($actcfg['batch_cols'] as $batch_col) {
				$batchvalue = $data_fixed[$batch_col];
				if ($actcfg['batch_type'] == 'comma') {
					$batchvalue = array_filter(explode(",", $batchvalue));
				}
				if (!is_array($batchvalue)) {
					$batchvalue = array($batchvalue);
				}
				$matrix[$batch_col] = $batchvalue;
			}
			$dp         = cartesian($matrix);
			$dp_count   = count($dp);
			$data_batch = array();
			for ($i = 0; $i < $dp_count; $i++) {
				$row          = array_merge($data_fixed, $dp[$i]);
				$data_batch[] = $row;
			}
			return $data_batch;

		}

		if (array_key_exists('key_for_array_col_data', $actcfg)) {
			$ref_key = $actcfg['key_for_array_col_data'];
			$fixed   = singlearray_join_assocarray($data_fixed, $data_received[$ref_key]);
			return $fixed;
		}
		return array($data_fixed);
	}

	function getConnectionInfo($para) {

		$info                = array();
		$info['inner_table'] = $para['table'];
		$info['user']        = $para['field_e'];
		//	$info['inner_table_pid'] = $para[''];

		$onr_row = $para['extradata']->data[0];
		$pid     = $onr_row->pid;

		$info['inner_table_pid'] = $pid;

		return $info;
	}

	function getFormLayoutData($para) {

		$rawtb              = $para['table'];
		$opcode_with_randno = $para['hostby'];
		$col_count          = $para['extradata']->col_count;
		$row_count          = $para['extradata']->row_count;
		$layout             = array();
		for ($i = 0; $i < $row_count; $i++) {
			$row = array();
			for ($j = 0; $j < $col_count; $j++) {
				$key       = 'col_' . $j;
				$row[$key] = 'aaa';
				if (property_exists($para['extradata']->data[$i], $key)) {
					$row[$key] = $para['extradata']->data[$i]->$key;
				} else {
					$row[$key] = '';
				}
			}
			array_push($layout, $row);
		}

		$zip = arrayzip($layout);

		$records = array();
		for ($i = 0; $i < count($zip); $i++) {
			$keys       = array_keys($zip[$i]);
			$field_list = '';
			for ($j = 0; $j < count($keys); $j++) {
				$tmp_v = $zip[$i][$keys[$j]];
				if (strlen($tmp_v) == 0) {
					$tmp_v = 'NULL';
				}

				$field_list .= $tmp_v . ",";
			}
			$field_list = substr($field_list, 0, -1);

			$record = array(
				'activity_code' => $opcode_with_randno,
				'raw_table'     => $rawtb,
				'row'           => $i,
				'field_list'    => $field_list);
			$records[] = $record;
		}
		return $records;
	}

	function getTriggerGroupData($para) {
		$para['filter_field_1'] = null;
		$records                = array();
		for ($i = 1; $i <= $para['trigger_counts']; $i++) {
			$records[] = array(
				'base_table'   => $para['hostby'],
				'group_id'     => $para['group_id'],
				'field_e'      => $para['field_e_' . $i],
				'combo_table'  => $para['combo_table_' . $i],
				'group_type'   => 'isgroup',
				'list_field'   => $para['list_field_' . $i],
				'value_field'  => $para['value_field_' . $i],
				'filter_field' => $para['filter_field_' . $i],
				'level'        => $i);
		}
		return $records;
	}

	function getDefalultValue($para) {
		$res = array();

		if ($para['f_def_fix'] == 1) {
			$res['default_v'] = $para['f_def_fix_input'];
		}

		if ($para['f_def_date'] == 1) {
			$res['default_v'] = 'date';
		}

		if ($para['f_def_datetime'] == 1) {
			$res['default_v'] = 'datetime';
		}

		if ($para['f_def_null'] == 1) {
			$res['default_v'] = '';
		}
		return array($res);
	}

	function rdbms_action($dbcmdtype, $x_cfg) {
		$paracfg = $x_cfg[0];
		if ($dbcmdtype == 'create_table') {
			$DDL       = $paracfg['DDL'];
			$tbname    = $paracfg['newtable'];
			$biztbname = $paracfg['base_table'];
			$this->createTable($DDL, $tbname, $biztbname);
		}

		if ($dbcmdtype == 'delete_col') {
			$tb      = $paracfg['usedtable'];
			$dropcol = $paracfg['dropcol'];
			if ($dropcol == 'pid') {
				return;
			}
			$sql = "alter table $tb  drop $dropcol   ";
			$this->db->query($sql);
		}

		if ($dbcmdtype == 'rename_col') {
			$orgincol = $paracfg['orgincol'];
			if ($orgincol == 'pid') {
				return;
			}
			$tb                = $paracfg['usedtable'];
			$newname           = $paracfg['newcolname'];
			$column_definition = $paracfg['column_definition'];
			$sql               = "alter table $tb  change column  $orgincol    $newname    $column_definition ";
			$this->db->query($sql);
		}

		if ($dbcmdtype == 'truncate_table') {
			$tb  = $paracfg['usedtable'];
			$sql = "truncate table $tb ";
			$this->db->query($sql);
		}

		if ($dbcmdtype == 'rename_table') {
			$tb    = $paracfg['usedtable'];
			$newtb = $paracfg['newtable'];
			if ($tb == $newtb) {
				$sql = 'select 1';
			} else {
				$sql = "rename  table $tb  to  $newtb ";
			}
			$this->db->query($sql);
		}

		if ($dbcmdtype == 'copy_table') {
			$tb    = $paracfg['usedtable'];
			$newtb = $paracfg['newtable'];
			$sql   = "create table $newtb as select * from  $tb";
			$this->db->query($sql);
		}

		if ($dbcmdtype == 'set_col_order') {
			$tb                  = $paracfg['nodevalue'];
			$reordered_columns   = $paracfg['extradata']->data;
			$field_definitions   = $this->getTableFullFields($tb);
			$reorder_columns_sql = $this->create_reorder_columns_sql($tb, $reordered_columns,
				$field_definitions);
			$this->db->query($reorder_columns_sql);
		}

		if ($dbcmdtype == 'drop_table') {
			$tb           = $paracfg['usedtable'];
			$sql_for_base = "delete from  nanx_biz_tables where table_name='$tb' ";
			$this->db->query($sql_for_base);
			$sql = "drop   table $tb ";
			$this->db->query($sql);
		}
	}

	function sendDbResult($actcfg) {
		if ($actcfg['dbcmdtype'] == 'upload_pic') {
			$res = array(
				'success'        => true,
				'file_operation' => true
			);
			return json_encode($res);
		}

		$successmsg = $this->lang->line('default_success_msg');
		$err_occur  = $this->lang->line('err_occur');
		if (array_key_exists('successmsg', $actcfg)) {
			$successmsg = $this->lang->line($actcfg['successmsg']);
		}
		$success        = true;
		$sqlresult_code = $this->db->_error_number();
		$errmsg         = $this->db->_error_message();
		if ($sqlresult_code > 0) {
			$success = false;
		}

		$res = array(
			'success' => $success,
			'opcode'  => $actcfg['opcode'],
			'msg'     => $successmsg,
			'errcode' => $sqlresult_code,
			'errmsg'  => $err_occur . "<br/> $errmsg");
		return json_encode($res);
	}

	function getFieldSource_and_follow() {

		$post  = file_get_contents('php://input');
		$para  = (array ) json_decode($post);
		$where = array('field_e' => $para['value'], 'base_table' => $para['hostby']);
		$this->db->where($where);
		$combo_cfg = $this->db->get('nanx_biz_column_trigger_group')->row_array();
		if (count($combo_cfg) > 0) {
			$combo_table      = $combo_cfg['combo_table'];
			$where_for_follow = array('base_table' => $para['hostby'], 'combo_table' => $combo_table);
			$this->db->where($where_for_follow);
			$follow_cfg = $this->db->get('nanx_biz_column_follow_cfg')->result_array();
		} else {
			$follow_cfg = array();
		}

		$combo_and_follow_cfg = array(
			'success'    => true,
			'msg'        => '',
			'combo_cfg'  => $combo_cfg,
			'follow_cfg' => $follow_cfg);
		echo json_encode($combo_and_follow_cfg);
	}

	function get_a2a_detail() {

		$post       = file_get_contents('php://input');
		$para       = (array ) json_decode($post);
		$pid        = $para['pid'];
		$sql        = "select * from nanx_activity_a2a_btns where pid=$pid";
		$a2a_detail = $this->db->query($sql)->result_array();

		$x = array(
			'success'    => true,
			'msg'        => '',
			'a2a_detail' => $a2a_detail[0]);
		echo json_encode($x);
	}

	function createTable($DDL, $rawtb, $biz) {
		if (strlen($biz) == 0) {
			$biz = $rawtb;
		}

		$sql     = str_replace("TB_TO_REPLACE", $rawtb, $DDL);
		$ret     = $this->db->query($sql);
		$errmsg  = $this->db->_error_message();
		$errno   = $this->db->_error_number();
		$success = true;
		if ($errno == 0) {
			$a = array('table_name' => $rawtb, 'table_screen_name' => $biz);
			$this->db->insert('nanx_biz_tables', $a);
		} else {
			$success = false;
		}

		$result = array(
			'success' => $success,
			'errmsg'  => $errmsg,
			'errno'   => $errno);
		return $result;
	}

	function dnd() {
		$post      = file_get_contents('php://input');
		$para      = (array ) json_decode($post);
		$src       = (array ) $para['src'];
		$target    = (array ) $para['target'];
		$opcode    = $this->getDnDOpcode($src, $target);
		$all       = $this->DndActionConfig();
		$dnd_opcfg = $all[$opcode];

		$tbused    = $dnd_opcfg['tbused'];
		$dbcmdtype = $dnd_opcfg['dbcmdtype'];
		$paracfg   = $dnd_opcfg['paracfg'];

		$data = array();
		$data = $this->getDndData($paracfg, $src, $target);

		if ($dbcmdtype == 'update') {
			$wherecfg = $dnd_opcfg['wherecfg'];
			$where    = $this->getDndWhere($wherecfg, $src, $target);
			$this->db->update($tbused, $data, $where);
		} else {
			$this->db->insert($tbused, $data);
		}

		$errno = $this->db->_error_number();

		if ($errno == 0) {
			$res = array(
				'success' => true,
				'opcode'  => $opcode,
				'msg'     => $this->lang->line('dnd_op_success'));
		} else {
			$res = array(
				'success' => false,
				'opcode'  => $opcode,
				'msg'     => $this->lang->line('dnd_op_failure'));
		}
		echo json_encode($res);
	}

	function getDndData($paracfg, $src, $target) {
		$data = array();
		foreach ($paracfg as $field => $field_cfg) {
			$f_src      = $field_cfg['getFrom'];
			$f_key_used = $field_cfg['value'];
			if ($f_src == 'src') {
				$value = $src[$f_key_used];
			}
			if ($f_src == 'target') {
				$value = $target[$f_key_used];
			}

			if ($f_src == 'local') {
				$value = $field_cfg['value'];
			}

			if (array_key_exists('function', $field_cfg)) {
				$value = $this->process_dnd_data_with_fun($field_cfg['function'], $value);
			}
			$data[$field] = $value;

		}
		return $data;
	}

	function process_dnd_data_with_fun($fun, $v) {
		if ($fun == 'generate_act_code') {
			$v = 'act_' . $v . '_' . mt_rand();
		}

		if ($fun == 'generate_act_name') {
			$act_prefix = $this->lang->line('activity');
			$v          = $act_prefix . '_' . $v;
		}

		return $v;
	}

	function getDndWhere($paracfg, $src, $target) {
		$where = array();
		foreach ($paracfg as $field => $field_cfg) {
			$f_src      = $field_cfg['getFrom'];
			$f_key_used = $field_cfg['value'];
			if ($f_src == 'src') {
				$value = $src[$f_key_used];
			}
			if ($f_src == 'target') {
				$value = $target[$f_key_used];
			}
			$where[$field] = $value;
		}
		return $where;
	}

	function getDnDOpcode($src, $target) {
		$src          = $src['category'];
		$target       = $target['category'];
		$cfgs         = $this->DnDSrcTargetCfg();
		$opcode_found = null;
		foreach ($cfgs as $opcode => $cfg) {
			if (($cfg['src'] == $src) && ($cfg['target'] == $target)) {
				$opcode_found = $opcode;
				break;
			}
		}
		return $opcode_found;
	}

	function getTableFullFields($table) {
		return $this->db->query(" show full fields from $table")->result_array();
	}

	function create_reorder_columns_sql($table, $reordered_columns, $fields) {
		$table_fields = array();
		foreach ($fields as $field) {
			$table_fields[$field['Field']] = $field;
		}
		$field_definitions = array();
		foreach ($reordered_columns as $key => $column) {
			$field      = $table_fields[$column->value];
			$definition = " MODIFY ";
			if ($field['Field']) {
				$definition .= " $field[Field] ";
			}
			if ($field['Type']) {
				$definition .= "  $field[Type]  ";
			}
			if ($field['Null'] == "NO") {
				$definition .= " NOT NULL ";
			} elseif ($field['Null'] == "YES") {
				$definition .= " NULL ";
			}
			if ($field['Collation']) {
				$definition .= " COLLATE $field[Collation] ";
			}
			if ($field['Default']) {
				$datatype = array_shift(explode("(", $field['Type']));
				if (preg_match_all("/[\s]/", $field['Default'], $matches) || strtolower($datatype) ==
					"enum") {
					$field['Default'] = "'" . $field['Default'] . "'";
				}
				$definition .= " DEFAULT $field[Default] ";
			}
			if ($field['Extra'] == "auto_increment") {
				$definition .= " AUTO_INCREMENT ";
			}
			if ($field['Comment']) {
				$definition .= " COMMENT '$field[Comment]' ";
			}
			if ($key < 1) {
				$definition .= " FIRST ";
			} else {
				$definition .= " AFTER " . $reordered_columns[$key - 1]->value;
			}
			$field_definitions[] = $definition;
		}
		$field_definition_str = implode(", ", $field_definitions);
		$sql                  = "ALTER TABLE $table $field_definition_str";
		return $sql;
	}

	function getTriggerGroup() {
		$post = file_get_contents('php://input');
		$para = (array ) json_decode($post);
		$w    = array('base_table' => $para['hostby'], 'group_id' => $para['value']);
		$this->db->where($w);
		$this->db->order_by('level');
		$rows = $this->db->get('nanx_biz_column_trigger_group')->result_array();
		$ret  = array(
			'success'     => true,
			'server_resp' => $rows,
			'errmsg'      => null);

		echo json_encode($ret);
	}

	function resize_image($file, $w, $h, $crop = false) {
		list($width, $height) = getimagesize($file);
		$r                    = $width / $height;
		if ($crop) {
			if ($width > $height) {
				$width = ceil($width-($width * ($r - $w / $h)));
			} else {
				$height = ceil($height-($height * ($r - $w / $h)));
			}
			$newwidth  = $w;
			$newheight = $h;
		} else {
			if ($w / $h > $r) {
				$newwidth  = $h * $r;
				$newheight = $h;
			} else {
				$newheight = $w / $r;
				$newwidth  = $w;
			}
		}
		$src = imagecreatefromjpeg($file);
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		return $dst;
	}

}

?>