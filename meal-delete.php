<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';
require_once '../../classes/DB.php';

if(!isset($_GET['id']))
{
	header("Location: meals.php");
}

$id = (int)$_GET['id'];
$table = 'meals';
$field = 'meal_id';

$meal = DB::dbActive()->deleteById($table, $field, $id);

if(!$meal)
{
	echo 'Could not delete the meal';
}

header('Location: meals.php');

?>