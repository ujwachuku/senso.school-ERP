<?php

require_once 'common/session-check.php';

$page = 'All Users';
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once 'classes/DB.php';
require_once 'classes/Sanitizer.php';

//Note to self: access to user list should be based on accessor role i.e. manager and admin should be able to access all users, vendors and customers should not be able to access user list
$sql = 'SELECT users.user_id, users.fname, users.lname, users.email, users.phone, users.created_at, users.updated_at, gender.gender_name, roles.role_name,status.status_name FROM users INNER JOIN gender ON users.gender_id = gender.gender_id INNER JOIN roles ON users.user_role_id = roles.role_id INNER JOIN status ON users.user_status_id = status.status_id ORDER BY users.fname ASC';
$users =  DB::dbActive()->get($sql)->results();

?>
<!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Users </h3>
        </div>

      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Users </h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if(count($users)): ?>
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <?php if($_SESSION['role'] == 1): ?>
                      <th></th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user): ?>
                  <tr>
                    <td><a href="edit-user.php?id=<?php echo $user->user_id; ?>" title="Click to edit user"><?php echo ucfirst(Sanitizer::XSS($user->fname)).' '.ucfirst(Sanitizer::XSS($user->lname)); ?></a></td>
                    <td><?php echo Sanitizer::XSS($user->email); ?></td>
                    <td><?php echo Sanitizer::XSS($user->phone); ?></td>
                    <td><?php echo ucfirst(Sanitizer::XSS($user->gender_name)); ?></td>
                    <td><?php echo ucfirst(Sanitizer::XSS($user->role_name)); ?></td>
                    <td><?php echo ucfirst(Sanitizer::XSS($user->status_name)); ?></td>
                    <td><?php echo Sanitizer::XSS($user->created_at); ?></td>
                    <td><?php echo Sanitizer::XSS($user->updated_at); ?></td>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                      <td align="center">
                        <a href="user-delete.php?id=<?php echo $user->user_id; ?>" class="btn btn-danger">Delete</a>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <strong>There are no users at this time.</strong>
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
