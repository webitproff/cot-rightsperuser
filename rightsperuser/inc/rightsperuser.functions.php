<?php
/**
 * Rights per user API
 * 
 * @package rightsperuser
 * @author Trustmaster
 * @copyright (c) Vladimir Sibirov, 2011
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Calculate database table name if not set in config.php
$db_rightsperuser = (isset($db_rightsperuser)) ? $db_rightsperuser : $db_x . 'rightsperuser';

?>
