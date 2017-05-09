<?php

require_once 'common/session-check.php';

$page = 'All Restaurant Categories';

require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$sql = 'SELECT * FROM restaurant_categories ORDER BY rest_category_name ASC';
$categories = DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Restaurant Categories </h3>
        </div>
       
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Restaurant Categories</h2>
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
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($categories as $category): ?>
                  <tr>
                    <td><a href="edit-rest-category.php?id=<?php echo $category->rest_category_id; ?>"><?php echo $category->rest_category_name; ?></a></td>
                    <td><?php echo $category->created_at; ?></td>
                    <td><?php echo $category->updated_at; ?></td>
                    <td align="center">
                    <?php
                     switch ($_SESSION['role'])
                     {
                        case 1:
                          echo '<a href="rest-category-delete.php?id=<?php echo $category->rest_category_id; ?>" class="btn btn-danger">Delete</a>';
                        break;
                        
                        case 2:
                        case 3:
                          echo '<a href="rest-category-disable.php?id=<?php echo $category->rest_category_id; ?>" class="btn btn-warning">Disable</a>';
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
                <strong>There are no restaurant categories at this time.</strong>
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