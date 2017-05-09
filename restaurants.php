<?php 

require_once 'common/session-check.php';

$page = 'All Restaurants'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT restaurants.restaurant_id, restaurants.restaurant_logo, restaurants.restaurant_name, restaurants.restaurant_address, restaurants.restaurant_email, restaurants.restaurant_phone, restaurants.created_at, restaurants.updated_at,  restaurant_categories.rest_category_name, status.status_name, users.fname, users.lname FROM restaurants INNER JOIN restaurant_categories ON restaurants.restaurant_category_id = restaurant_categories.rest_category_id INNER JOIN status ON restaurants.restaurant_status_id = status.status_id LEFT JOIN users ON restaurants.vendor_id = users.user_id ORDER BY restaurants.restaurant_name ASC';

$restaurants = DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Restaurants </h3>
        </div>
       
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Restaurants</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if(count($restaurants)): ?>
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Vendor</th>
                    <th>Created At</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($restaurants as $restaurant): ?>
                  <tr>
                    <td><a href="edit-restaurant.php?id=<?php echo $restaurant->restaurant_id; ?>"><?php echo ucfirst($restaurant->restaurant_name); ?> <img src="uploads/restaurants/<?php echo $restaurant->restaurant_logo; ?>" alt="<?php echo ucfirst($restaurant->restaurant_name); ?>" height="45" width="45" align="right" /></a></td>
                    <td><?php echo ucfirst($restaurant->restaurant_address); ?></td>
                    <td><?php echo $restaurant->restaurant_phone; ?></td>
                    <td><?php echo $restaurant->restaurant_email; ?></td>
                    <td><?php echo $restaurant->status_name; ?></td>
                    <td><?php echo ucfirst($restaurant->fname).' '.ucfirst($restaurant->lname); ?></td>
                    <td><?php echo $restaurant->created_at; ?></td>
                    <td align="center">
                    <?php
                     switch ($_SESSION['role'])
                     {
                        case 1:
                          echo '<a href="restaurant-delete.php?id=<?php echo $restaurant->restaurant_id; ?>" class="btn btn-danger">Delete</a>';
                        break;
                        
                        case 2:
                        case 3:
                          echo '<a href="restaurant-disable.php?id=<?php echo $restaurant->restaurant_id; ?>" class="btn btn-warning">Disable</a>';
                        break;

                     }
                    ?>  
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>There are no restaurants at this time.</strong>
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