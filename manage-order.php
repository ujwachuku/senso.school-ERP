<?php

require_once 'common/session-check.php';

if(!isset($_GET['id']))
{
  header('Location: orders.php');
}

$id = $_GET['id'];

$page = 'Manage Order';
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$errors = [];

$sql = 'SELECT orders.order_id, orders.order_subtotal, orders.order_total, orders.order_notes, orders.order_status_id, users.fname, users.lname, restaurants.restaurant_name FROM orders INNER JOIN users ON orders.user_id  = users.user_id INNER JOIN restaurants ON orders.restaurant_id = restaurants.restaurant_id WHERE orders.order_id = '.$id;

$orderDetailSql = 'SELECT order_details.meal_qty, meals.meal_name, meals.meal_price, meal_options.meal_option_name FROM order_details INNER JOIN meals ON order_details.meal_id = meals.meal_id INNER JOIN meal_options ON order_details.meal_options_id = meal_options.meal_option_id WHERE order_details.order_id = '.$id;

$orderInDb = DB::dbActive()->get($sql)->first();

$status = DB::dbActive()->get('SELECT * FROM order_status')->results();

$detailsInDb = DB::dbActive()->get($orderDetailSql)->results();

if(isset($_POST['submit']))
{
  if(isset($_POST['status']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST

    $order['status'] = $_POST['status'];

  }

  if(empty($errors))
  {

    $now = date('Y-m-d h:i:s');

    //Update meal
    $order['updated_at'] = $now;

    $query = 'UPDATE orders SET order_status_id = ?, updated_at = ? WHERE order_id = '.$id;

    $update = DB::dbActive()->query($query, $order);

    if(!$update)
    {
        $errors['not created'] = 'Order was not updated. Try again later';
    }
    else
    {
      unset($order);
      header('Location: orders.php');
    }
  }
}

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Manage Order </h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Order </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Customer Name</th>
                  <th>Restaurant</th>
                  <th>Sub Total</th>
                  <th>Total</th>
                  <th>Order Notes</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $orderInDb->order_id; ?></td>
                  <td><?php echo ucfirst($orderInDb->fname).' '.ucfirst($orderInDb->lname); ?></td>
                  <td><?php echo ucfirst($orderInDb->restaurant_name); ?></td>
                  <td><?php echo $orderInDb->order_subtotal; ?></td>
                  <td><?php echo $orderInDb->order_total; ?></td>
                  <td><?php echo ucfirst($orderInDb->order_notes); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <br/>
      <div align="center">
        <form class="form-inline form-label-left" method="post" action="">
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Update Order</label>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <select name="status" class="select2_single form-control" tabindex="-1">
              <option value="">Select Order Status</option>
              <?php foreach ($status as $state): ?>
                <option value="<?php echo $state->order_status_id; ?>" <?php echo $orderInDb->order_status_id === $state->order_status_id ? 'selected' : ''; ?> ><?php echo ucfirst($state->order_status_name); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
         <button type="submit" name="submit" class="btn btn-success">Update Order</button>
         <a href="orders.php" class="btn btn-danger">&larr; Back </a>
      </form>
      </div>
      <div class="clearfix"></div>
      <br/>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Order Details </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
            <?php if(count($detailsInDb)): ?>
              <table class="table table-striped jambo_table">
                <thead>
                  <tr class="headings">
                    <th class="column-title">Meal </th>
                    <th class="column-title">Price</th>
                    <th class="column-title">Quantity</th>
                    <th class="column-title">Options </th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($detailsInDb as $detail): ?>
                  <tr class="even pointer">
                    <td class=" "><?php echo ucfirst($detail->meal_name); ?></td>
                    <td class=" "><?php echo $detail->meal_price; ?></td>
                    <td class=" "><?php echo $detail->meal_qty; ?></td>
                    <td class=" "><?php echo ucfirst($detail->meal_option_name); ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>There are no order details at this time.</strong>
              </div>
            <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php require_once 'common/footer.php'; ?>
