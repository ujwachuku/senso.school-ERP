<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';
require_once '../../classes/DB.php';

if(!isset($_GET['id']))
{
	header("Location: restaurants.php");
}

$id = (int)$_GET['id'];
$table = 'restaurants';
$field = 'restaurant_id';

$restaurant = DB::dbActive()->deleteById($table, $field, $id);

if(!$restaurant)
{
	echo 'Could not delete the restaurant';
}

header('Location: restaurants.php');

?>