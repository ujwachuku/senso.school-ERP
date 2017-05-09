<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';
require_once '../../classes/DB.php';

if(!isset($_GET['id']))
{
	header("Location: cities.php");
}

$id = $_GET['id'];
$table = 'cities';
$field = 'city_id';

$city = DB::dbActive()->deleteById($table, $field, $id);

if(!$city)
{
	echo 'Could not delete the city';
}

header('Location: cities.php');

?>