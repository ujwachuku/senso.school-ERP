<?php 

require_once 'common/session-check.php';

$page = 'All Orders'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT orders.order_id, orders.order_subtotal, orders.order_total, orders.shipping_charge, orders.order_notes, order_status.order_status_name, orders.created_at, orders.updated_at, restaurants.restaurant_name, users.fname, users.lname FROM orders INNER JOIN restaurants ON orders.restaurant_id = restaurants.restaurant_id INNER JOIN users ON orders.user_id = users.user_id INNER JOIN order_status ON orders.order_status_id = order_status.order_status_id ORDER BY orders.order_id ASC';

$orders =  DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Orders </h3>
        </div>
       
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Orders</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if(count($orders)): ?>  
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Order No.</th>
                    <th>Restaurant</th>
                    <th>Customer</th>
                    <th>Sub Total</th>
                    <th>Total</th>
                    <th>Shipping Charge</th>
                    <th>Order Notes</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($orders as $order): ?>
                  <tr>
                    <td><a href="manage-order.php?id=<?php echo $order->order_id; ?>">#<?php echo $order->order_id; ?></a></td>
                    <td><?php echo ucfirst($order->restaurant_name); ?></td>
                    <td><?php echo ucfirst($order->fname).' '.ucfirst($order->lname); ?></td>
                    <td><?php echo $order->order_subtotal; ?></td>
                    <td><?php echo $order->order_total; ?></td>
                    <td><?php echo $order->shipping_charge; ?></td>
                    <td><?php echo ucfirst($order->order_notes); ?></td>
                    <td><?php echo ucfirst($order->order_status_name); ?></td>
                    <td><?php echo $order->created_at; ?></td>
                    <td><?php echo $order->updated_at; ?></td>
                  </tr>
                <?php endforeach; ?>  
                </tbody>
              </table>
          <?php else: ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <strong>There are no orders at this time.</strong>
            </div>
          <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- /page content -->
<?php require_once 'common/footer.php'; ?>