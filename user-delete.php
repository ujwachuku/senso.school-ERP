<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';

require_once '../../classes/DB.php';

if(!isset($_GET['id']))
{
	header("Location: users.php");
}

$id = (int)$_GET['id'];
$table = 'users';
$field = 'user_id';

$user = DB::dbActive()->deleteById($table, $field, $id);

if(!$user)
{
	echo 'Could not delete the user';
}

header('Location: users.php');

?>