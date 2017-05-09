<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';

require_once '../../classes/DB.php';

if(!isset($_GET['id']))
{
	header("Location: restaurant-categories.php");
}

$id = (int)$_GET['id'];
$table = 'restaurant_categories';
$field = 'rest_category_id';

$category = DB::dbActive()->deleteById($table, $field, $id);

if(!$category)
{
	echo 'Could not delete the restaurant category';
}

header("Location: restaurant-categories.php");

?>