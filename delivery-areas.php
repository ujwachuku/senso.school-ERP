<?php 

require_once 'common/session-check.php';

$page = 'All Restaurant Delivery Areas'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT restaurants.restaurant_id, restaurants.restaurant_name, COUNT(delivery_areas.restaurant_id) as areaCount FROM restaurants INNER JOIN delivery_areas on restaurants.restaurant_id = delivery_areas.restaurant_id GROUP BY delivery_areas.restaurant_id ORDER BY restaurants.restaurant_name ASC';

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
                    <th>Restaurant</th>
                    <th>Area Count</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($restaurants as $restaurant): ?>
                  <tr>
                    <td><?php echo ucfirst($restaurant->restaurant_name); ?></td>
                    <td>
                      <?php echo $restaurant->areaCount; ?>
                      <?php echo $restaurant->areaCount > 1 ? ' City areas ' : ' City area '; ?>  
                    </td>
                    <td align="center">
                      <a href="update-delivery-area.php?id=<?php echo $restaurant->restaurant_id; ?>" class="btn btn-warning">Edit</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>There are no delivery areas at this time.</strong>
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