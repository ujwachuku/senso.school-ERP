<?php

require_once 'common/session-check.php';
require_once '../../classes/DB.php';

if(!isset($_GET['id']))
{
	header("Location: meal-categories.php");
}

$id = (int)$_GET['id'];
$table = 'meal_categories';
$field = 'meal_category_id';

$category = DB::dbActive()->deleteById($table, $field, $id);

if(!$category)
{
	echo 'Could not delete the meal category';
}

header("Location: meal-categories.php");

?>