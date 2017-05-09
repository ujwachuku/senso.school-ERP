<?php

require_once 'common/session-check.php';

$page = 'Add User';
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once 'classes/DB.php';
require_once 'classes/User.php';


$errors = [];

$roles = DB::dbActive()->get('SELECT * FROM roles')->results();
$gender = DB::dbActive()->get('SELECT * FROM gender')->results();
$status = DB::dbActive()->get('SELECT * FROM status')->results();

if(isset($_POST['submit']))
{
  if(isset($_POST['firstname'], $_POST['lastname'], $_POST['gender'], $_POST['password'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['role'], $_POST['status']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST

    $user['first name'] = $_POST['firstname'];
    $user['last name'] = $_POST['lastname'];
    $user['gender'] = $_POST['gender'];
    $user['password'] = $_POST['password'];
    $user['email'] = $_POST['email'];
    $user['address'] = $_POST['address'];
    $user['phone'] = $_POST['phone'];
    $user['role'] = $_POST['role'];
    $user['status'] = $_POST['status'];

    foreach ($user as $key => $value)
    {
      if(empty($value))
      {
        $errors[$key] = ucfirst($key).' is required';
      }
    }

    //Check if email already exists in the db
    $testEmail = $user['email'];

    $sql = 'SELECT email FROM users WHERE email = '.'"'.$testEmail.'"';

    if(!empty($testEmail))
    {
      $emailInDb = DB::dbActive()->get($sql)->count();

      if($emailInDb > 0)
      {
          $errors['duplicate email'] = 'Email already exists';
      }
    }

  }

  if(empty($errors))
  {

    $now = date('Y-m-d h:i:s');

    //Create user
    $create = new User();

    $user['password'] = password_hash($user['password'],PASSWORD_DEFAULT);
    $user['created_at'] = $now;
    $user['updated_at'] = $now;

    if(!$create->create($user))
    {
        $errors['not created'] = 'User was not created. Try again later';
    }
    else
    {
        //$message = 'User has been succesfully created.';
        unset($user);
        header('Location: users.php');
    }
  }
}



?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Add User</h3>
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add User</h2>
            <div class="clearfix"></div>
          </div>
          <?php if(count($errors)): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <strong>Warning!</strong>
              <?php foreach($errors as $error): ?>
                <p><?php echo $error; ?> </p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <?php if(!empty($message)): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <strong>Great!</strong> <?php echo ucfirst($message); ?>
            </div>
          <?php endif; ?>
          <div class="x_content">
            <br />
            <form id="demo-form2" class="form-horizontal form-label-left " action="" method="post">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">First Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="firstname" required="required" class="form-control col-md-7 col-xs-12"
                  value="<?php echo isset($user['first name']) ? $user['first name'] : ''; ?>">
                  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">Last Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="last-name" name="lastname" required="required" class="form-control col-md-7 col-xs-12"
                  value="<?php echo isset($user['last name']) ? $user['last name'] : ''; ?>">
                  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Gender <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="gender" required="required" class="select2_group form-control">
                    <option value="">Select Gender</option>
                    <?php foreach ($gender as $sex): ?>
                      <option value="<?php echo $sex->gender_id; ?>" <?php echo isset($user['gender']) && $user['gender'] === $sex->gender_id ? 'selected' : ''; ?> ><?php echo ucfirst($sex->gender_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
                  <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="email" class="form-control col-md-7 col-xs-12" type="email" required="required" name="email"
                  value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="address" name="address" required="required" class="form-control col-md-7 col-xs-12"
                  value="<?php echo isset($user['address']) ? $user['address'] : ''; ?>">
                  <span class="fa fa-home form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="phone" class="form-control col-md-7 col-xs-12" name="phone" required="required" type="tel"
                  value="<?php echo isset($user['phone']) ? $user['phone'] : ''; ?>">
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">User Role <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="role" class="select2_group form-control" required="required">
                    <option value="">Select Role</option>
                    <?php foreach($roles as $role): ?>
                      <option value="<?php echo $role->role_id; ?>" <?php echo isset($user['role']) && $user['role'] === $role->role_id ? 'selected' : ''; ?> ><?php echo ucfirst($role->role_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Status <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="status" required="required" class="select2_group form-control">
                    <option value="">Select Status</option>
                    <?php foreach($status as $state): ?>
                      <option value="<?php echo $state->status_id; ?>" <?php echo isset($user['status']) && $user['status'] === $state->status_id ? 'selected' : ''; ?> ><?php echo ucfirst($state->status_name); ?> </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <button type="submit" name="submit" class="btn btn-success">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
  </div>
  <div class="clearfix"></div>
</div>
</div>
<!-- page content -->
<?php require_once 'common/footer.php'; ?>
