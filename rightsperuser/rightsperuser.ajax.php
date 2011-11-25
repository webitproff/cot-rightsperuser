<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

$code = cot_import('code', 'G', 'ALP');

// Get options for given code
$options = $db->query("SELECT DISTINCT auth_option FROM $db_auth WHERE auth_code = ?",
		array($code))->fetchAll(PDO::FETCH_COLUMN);

// Output as JSON
header('Content-Type: application/json');
echo json_encode($options);

?>
