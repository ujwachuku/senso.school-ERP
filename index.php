<?php

require_once 'common/session-check.php';

$page = 'Admin Dashboard';

require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once 'classes/DB.php';

//$topRestaurants = DB::dbActive()->get('SELECT restaurants.restaurant_name, restaurants.created_at, SUM(orders.order_total) AS orderTotal, COUNT(orders.restaurant_id) AS orderCount FROM restaurants INNER JOIN orders ON restaurants.restaurant_id = orders.restaurant_id WHERE orders.order_status_id = 1 GROUP BY restaurants.restaurant_name ORDER BY orderTotal DESC LIMIT 3')->results();

//$topCustomers = DB::dbActive()->get('SELECT users.fname, users.lname, users.created_at, SUM(orders.order_total) AS orderTotal, COUNT(orders.user_id) AS orderCount FROM users INNER JOIN orders ON users.user_id = orders.user_id WHERE orders.order_status_id = 1 GROUP BY users.fname ORDER BY orderTotal DESC LIMIT 3')->results();

//$users = DB::dbActive()->get('SELECT COUNT(*) AS userCount FROM users')->first();
//$restaurants = DB::dbACtive()->get('SELECT COUNT(*) AS restaurantCount FROM restaurants')->first();
//$orders = DB::dbActive()->get('SELECT COUNT(*) AS orderCount FROM orders WHERE orders.order_status_id = 1')->first();
//$totalOrderValue = DB::dbActive()->get('SELECT SUM(order_total) AS total FROM orders WHERE orders.order_status_id = 1')->first();
//$totalCommissionValue = DB::dbActive()->get('SELECT SUM(orders.commission) AS commissionTotal FROM orders WHERE orders.order_status_id = 1')->first();



?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="row top_tiles">
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-users"></i></div>
          <div class="count"><?php //echo $users->userCount; ?></div>
          <h3>All Users</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-cutlery"></i></div>
          <div class="count"><?php //echo $restaurants->restaurantCount; ?></div>
          <h3>All Restaurants</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-money"></i></div>
          <div class="count"><?php //echo $orders->orderCount; ?></div>
          <h3>Completed Orders</h3>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Revenue Summary <small>Weekly progress</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-9 col-sm-12 col-xs-12">
              <div class="demo-container" style="height:280px">
                <div id="placeholder33x" class="demo-placeholder"></div>
              </div>
              <div class="tiles">
                <div class="col-md-6 tile">
                  <span>Total Order Value</span>
                  <h2><?php //echo $_SESSION['position'] == 1 ? $totalOrderValue->total.' '.$_SESSION['currency'] : $_SESSION['currency'].' '.$totalOrderValue->total; ?></h2>
                </div>
                <div class="col-md-6 tile">
                  <span>Total Commission Revenues</span>
                  <h2><?php //echo $_SESSION['position'] == 1 ? $totalCommissionValue->commissionTotal.' '.$_SESSION['currency'] : $_SESSION['currency'].' '.$totalCommissionValue->commissionTotal; ?></h2>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div>
                <div class="x_title">
                  <h2>Top Restaurants</h2>
                  <div class="clearfix"></div>
                </div>
                <ul class="list-unstyled top_profiles scroll-view">
                <?php //foreach($topRestaurants as $topRestaurant): ?>
                  <li class="media event">
                    <a class="pull-left border-aero profile_thumb">
                      <i class="fa fa-cutlery aero"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#"><?php //echo ucfirst($topRestaurant->restaurant_name); ?></a>
                      <p><strong><?php //echo $_SESSION['position'] == 1 ? $topRestaurant->orderTotal.' '.$_SESSION['currency'] : $_SESSION['currency'].' '.$topRestaurant->orderTotal; ?></strong> Order Value</p>
                      <p> <small><?php //echo $topRestaurant->orderCount; ?><?php //echo $topRestaurant->orderCount > 1 ? ' Orders' : ' Order'; ?></small>
                      </p>
                      <p> <b>Joined:</b> <small><?php //echo date('Y-m-d', strtotime($topRestaurant->created_at)); ?></small>
                      </p>
                    </div>
                  </li>
                <?php //endforeach; ?>
                </ul>
              </div>
              <div>
                <div class="x_title">
                  <h2>Top Customers</h2>
                  <div class="clearfix"></div>
                </div>
                <ul class="list-unstyled top_profiles scroll-view">
                <?php //foreach($topCustomers as $topCustomer): ?>
                  <li class="media event">
                    <a class="pull-left border-aero profile_thumb">
                      <i class="fa fa-user aero"></i>
                    </a>
                    <div class="media-body">
                      <a class="title" href="#"><?php //echo ucfirst($topCustomer->fname).' '.ucfirst($topCustomer->lname); ?></a>
                      <p><strong><?php //echo $_SESSION['position'] == 1 ? $topCustomer->orderTotal.' '.$_SESSION['currency'] : $_SESSION['currency'].' '.$topCustomer->orderTotal; ?></strong> Order Value </p>
                      <p> <small><?php //echo $topCustomer->orderCount; ?><?php //echo $topCustomer->orderCount > 1 ? ' Orders' : ' Order'; ?></small>
                      </p>
                      <p> <b>Joined:</b> <small><?php //echo date('Y-m-d', strtotime($topCustomer->created_at)); ?></small></p>
                    </div>
                  </li>
                <?php //endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php require_once 'common/footer.php'; ?>
