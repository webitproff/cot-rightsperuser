<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

// We need Forms API to generate form elements
require_once cot_incfile('forms');
// Own functions and globals
require_once cot_incfile('rightsperuser', 'plug');

// Masks to rights conversion table
$mn = array();
$mn['R'] = 1;
$mn['W'] = 2;
$mn['1'] = 4;
$mn['2'] = 8;
$mn['3'] = 16;
$mn['4'] = 32;
$mn['5'] = 64;
$mn['A'] = 128;

// Rule ID
$id = cot_import('id', 'G', 'INT');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Get the submitted item
	$rule = array();
	// We need an ID from database for the user name specified
	$user_name = cot_import('user', 'P', 'TXT');
	$res = $db->query("SELECT user_id, user_maingrp FROM $db_users
			WHERE user_name = ?", array($user_name));
	if ($res->rowCount() == 1)
	{
		// OK, user found
		$row = $res->fetch();
		if ($row['user_maingrp'] == COT_GROUP_SUPERADMINS)
		{
			// Don't affect superadmins
			cot_error('rightsperuser_superadmin', 'user');
		}
		else
		{
			// Got user ID
			$rule['ru_user'] = (int) $row['user_id'];
		}
	}
	else
	{
		// No such user
		cot_error('rightsperuser_invalid_user', 'user');
	}
	$rule['ru_code'] = cot_import('code', 'P', 'ALP');
	$rule['ru_option'] = cot_import('option', 'P', 'ALP');
	// Calculate rights byte
	$rights = 0;
	foreach ($mn as $key => $val)
	{
		if (cot_import('auth_'.$key, 'P', 'BOL'))
		{
			$rights += $val;
		}
	}
	$rule['ru_rights'] = $rights;
}
	
if ($a == 'add')
{
	// Adding a new rule
	if ($db->query("SELECT COUNT(*) FROM $db_rightsperuser
			WHERE ru_user = ? AND ru_code = ? AND ru_option = ?",
			array($rule['ru_user'], $rule['ru_code'], $rule['ru_option']))
			->fetchColumn() > 0)
	{
		cot_error('rightsperuser_duplicate');
	}

	if (!cot_error_found())
	{
		// Insert a new DB record
		$db->insert($db_rightsperuser, $rule);
		// Send success message
		cot_message('rightsperuser_added');
		// Back to main to avoid refresh accidents
		cot_redirect(cot_url('admin', 'm=other&p=rightsperuser', '', true));
	}
}
elseif ($a == 'update' && $id > 0)
{
	// Updating an existing rule
	if ($db->query("SELECT COUNT(*) FROM $db_rightsperuser WHERE ru_id = ?",
			array($id)) == 0)
	{
		cot_error('rightsperuser_notfound');
	}

	if (!cot_error_found())
	{
		// Update record in DB
		$db->update($db_rightsperuser, $rule, "ru_id = ?", array($id));
		// Send success message
		cot_message('rightsperuser_updated');
		// Back to main to avoid refresh accidents
		cot_redirect(cot_url('admin', 'm=other&p=rightsperuser', '', true));
	}
}
elseif ($a == 'delete' && $id > 0)
{
	// Existing rule removal
	$num = $db->delete($db_rightsperuser, "ru_id = ?", array($id));
	// Send the message
	($num > 0) ? cot_message('rightsperuser_deleted')
		: cot_error('rightsperuser_delete_error');
	// Back to main to avoid refresh accidents
	cot_redirect(cot_url('admin', 'm=other&p=rightsperuser', '', true));
}

// Render the rules table and form

// Create the template object
$rt = new XTemplate(cot_tplfile('rightsperuser', 'plug'));

// Pagination parameters: page number, database offset and url parameter
list($pg, $d, $durl) = cot_import_pagenav('d',
		$cfg['plugin']['rightsperuser']['rules_perpage']);

// Get available auth codes
$auth_codes = $db->query("SELECT DISTINCT auth_code
		FROM $db_auth")->fetchAll(PDO::FETCH_COLUMN);

// SELECT all rules
$res = $db->query("SELECT r.*, u.user_name
	FROM $db_rightsperuser AS r
		LEFT JOIN $db_users AS u ON r.ru_user = u.user_id
	ORDER BY ru_user, ru_code, ru_option
	LIMIT $d, {$cfg['plugin']['rightsperuser']['rules_perpage']}");
	
// Loop through the result rowset
foreach ($res->fetchAll() as $row)
{
	// Generate checkboxes for each kind of permissions
	foreach ($mn as $key => $val)
	{
		$checked = (($row['ru_rights'] & $val) == $val);
		$rt->assign('RIGHTSPERUSER_ROW_AUTH_'.$key,
				cot_checkbox($checked, 'auth_'.$key));
	}
	// Get the options for selected code
	$options = $db->query("SELECT DISTINCT auth_option FROM $db_auth
			WHERE auth_code = ?", array($row['ru_code']))
			->fetchAll(PDO::FETCH_COLUMN);
	// Generate other tags
	$id = $row['ru_id'];
	$rt->assign(array(
		'RIGHTSPERUSER_ROW_ACTION'
			=> cot_url('admin', 'm=other&p=rightsperuser&a=update&id='.$id),
		'RIGHTSPERUSER_ROW_USER'
			=> cot_inputbox('text', 'user', $row['user_name'],
				array('class' => 'user')),
		'RIGHTSPERUSER_ROW_CODE'
			=> cot_selectbox($row['ru_code'], 'code', $auth_codes, $auth_codes,
				false, array('class' => 'code', 'id' => 'code_'.$id)),
		'RIGHTSPERUSER_ROW_OPTION'
			=> cot_selectbox($row['ru_option'], 'option', $options, $options,
				false, array('class' => 'option', 'id' => 'opt_'.$id)),
		'RIGHTSPERUSER_ROW_DELETE_URL'
			=> cot_url('admin', 'm=other&p=rightsperuser&a=delete&id='.$id)
	));
	$rt->parse('MAIN.RIGHTSPERUSER_ROW');
}

// Display error/success messages
cot_display_messages($rt);

// Generate tags for adding form
$options = empty($rule['ru_code']) ? array('---')
	: $db->query("SELECT DISTINCT auth_option FROM $db_auth WHERE auth_code = ?",
		array($rule['ru_code']))->fetchAll(PDO::FETCH_COLUMN);
foreach ($mn as $key => $val)
{
	$checked = (($rule['ru_rights'] & $val) == $val);
	$rt->assign('RIGHTSPERUSER_ADD_AUTH_'.$key,
			cot_checkbox($checked, 'auth_'.$key));
}
$rt->assign(array(
	'RIGHTSPERUSER_ADD_ACTION'
		=> cot_url('admin', 'm=other&p=rightsperuser&a=add'), 
	'RIGHTSPERUSER_ADD_USER'
		=> cot_inputbox('text', 'user', $user_name,
			array('class' => 'user')),
	'RIGHTSPERUSER_ADD_CODE'
		=> cot_selectbox($rule['ru_code'], 'code', $auth_codes, $auth_codes,
			true, array('class' => 'code', 'id' => 'code_add')),
	'RIGHTSPERUSER_ADD_OPTION'
		=> cot_selectbox($rule['ru_option'], 'option', $options, $options,
			false, array('class' => 'option', 'id' => 'opt_add'))
));

// Render pagination
$totalitems = $db->query("SELECT COUNT(*)
		FROM $db_rightsperuser")->fetchColumn();
$pagenav = cot_pagenav('admin', 'm=other&p=rightsperuser', $d, $totalitems,
		$cfg['plugin']['rightsperuser']['rules_perpage']);

$rt->assign(array(
	'RIGHTSPERUSER_PAGENAV_PREV' => $pagenav['prev'],
	'RIGHTSPERUSER_PAGENAV_MAIN' => $pagenav['main'],
	'RIGHTSPERUSER_PAGENAV_NEXT' => $pagenav['next']
));

// Render the output and pass it to the main admin template
$rt->parse();
$plugin_body = $rt->text();

// Render the help part
$rt->parse('HELP');
$adminhelp = $rt->text('HELP');

?>
