<?php 

require_once 'common/session-check.php';

$page = 'All Meals'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT meals.meal_id, meals.meal_name, meals.meal_price, meal_categories.meal_category_name, restaurants.restaurant_name, status.status_name, meals.created_at, meals.updated_at FROM meals INNER JOIN meal_categories ON meals.meal_category_id = meal_categories.meal_category_id INNER JOIN restaurants ON meals.meal_restaurant_id = restaurants.restaurant_id INNER JOIN status ON meals.meal_status_id = status.status_id ORDER BY meals.meal_name ASC';

$meals =  DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Meals </h3>
        </div>
       
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Meals</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if(count($meals)): ?>  
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Restaurant</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($meals as $meal): ?>
                  <tr>
                    <td><a href="edit-meal.php?id=<?php echo $meal->meal_id; ?>"><?php echo ucfirst($meal->meal_name); ?></a></td>
                    <td><?php echo $meal->meal_price; ?></td>
                    <td><?php echo ucfirst($meal->meal_category_name); ?></td>
                    <td><?php echo ucfirst($meal->restaurant_name); ?></td>
                    <td><?php echo ucfirst($meal->status_name); ?></td>
                    <td><?php echo ucfirst($meal->created_at); ?></td>
                    <td><?php echo ucfirst($meal->updated_at); ?></td>
                    <td align="center">
                    <?php
                     switch ($_SESSION['role'])
                     {
                        case 1:
                          echo '<a href="meal-delete.php?id=<?php echo $meal->meal_id; ?>" class="btn btn-danger">Delete</a>';
                        break;
                        
                        case 2:
                        case 3:
                          echo '<a href="meal-disable.php?id=<?php echo $meal->meal_id; ?>" class="btn btn-warning">Disable</a>';
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
              <strong>There are no meals at this time.</strong>
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