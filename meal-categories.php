<?php

require_once 'common/session-check.php';

$page = 'All Meal Categories';

require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT * FROM meal_categories';
$categories = DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Meal Categories </h3>
        </div>
       
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Meal Categories</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if(count($categories)): ?>
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                  <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                    <th></th>
                  <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($categories as $category): ?>
                  <tr>
                    <td><a href="edit-meal-category.php?id=<?php echo $category->meal_category_id; ?>"><?php echo $category->meal_category_name; ?></a></td>
                    <td><?php echo $category->created_at; ?></td>
                    <td><?php echo $category->updated_at; ?></td>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                      <td align="center">
                        <a href="meal-category-delete.php?id=<?php echo $category->meal_category_id; ?>" class="btn btn-danger">Delete</a>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
              <?php else: ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>There are no meal categories at this time.</strong>
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