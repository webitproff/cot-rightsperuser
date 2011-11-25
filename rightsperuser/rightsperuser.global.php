<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
Order=1
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if ($usr['id'] > 0)
{
	// Self API required
	require_once cot_incfile('rightsperuser', 'plug');
	
	// Load all rules for current user
	$res = $db->query("SELECT * FROM $db_rightsperuser WHERE ru_user = ?", array($usr['id']));
	while ($row = $res->fetch())
	{
		$usr['auth'][$row['ru_code']][$row['ru_option']] = $row['ru_rights'];
	}
}

?>
