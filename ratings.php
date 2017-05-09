<?php 

require_once 'common/session-check.php';

$page = 'All Ratings and Reviews';

require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT ratings.rating_id, ratings.rating, ratings.review, ratings.created_at, restaurants.restaurant_name, users.fname, users.lname FROM ratings INNER JOIN restaurants ON ratings.restaurant_id = restaurants.restaurant_id INNER JOIN users ON ratings.user_id = users.user_id ORDER BY rating_id ASC';
$ratings = DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Ratings and Reviews </h3>
        </div>
       
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All ratings and Reviews</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if(count($ratings)): ?>
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Restaurant</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Created At</th>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                      <th></th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($ratings as $rating): ?>
                  <tr>
                    <td><?php echo $rating->rating_id; ?></td>
                    <td><?php echo ucfirst($rating->fname).' '.ucfirst($rating->lname); ?></td>
                    <td><?php echo ucfirst($rating->restaurant_name); ?></td>
                    <td><?php echo round($rating->rating); ?></td>
                    <td><?php echo substr(ucfirst($rating->review), 0, 100); ?></td>
                    <td><?php echo $rating->created_at; ?></td>
                    <td>
                      <a href="rating-disable.php?id=<?php echo $rating->rating_id; ?>" class="btn btn-warning">Disable</a>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                      <a href="rating-delete.php?id=<?php echo $rating->rating_id; ?>" class="btn btn-danger">Delete</a>
                    <?php endif; ?>
                    </td>
                    
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
              <?php else: ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>There are no ratings and reviews at this time.</strong>
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