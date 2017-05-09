<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';

require_once '../../classes/DB.php';

if(!isset($_GET['id'], $_GET['url']))
{
	header("Location: delivery-areas.php");
}

$id = $_GET['id'];
$returnUrl = base64_decode($_GET['url']);
$table = 'delivery_areas';
$field = 'delivery_area_id';

$area = DB::dbActive()->deleteById($table, $field, $id);

if(!$area)
{
	echo 'Could not delete the delivery area';
}

header('Location: '.$returnUrl);

?>