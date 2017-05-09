<?php

require_once 'common/session-check.php';

$page = 'School Settings';

require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once 'classes/DB.php';
require_once 'classes/School.php';
require_once 'classes/Sanitizer.php';

$error = '';
$message = '';

$types = DB::dbActive()->get('SELECT * FROM school_types')->results();
$schoolInDb = DB::dbActive()->single('SELECT * FROM school')->result();

if(isset($_POST['name'], $_POST['type'], $_POST['address'], $_POST['email'], $_POST['phone'], $_POST['contact'], $_POST['fax'], $_POST['mobile']))
{
  $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST

  $school['name'] = $_POST['name'];
  $school['type'] = $_POST['type'];
  $school['address'] = $_POST['address'];
  $school['email'] = $_POST['email'];
  $school['phone'] = $_POST['phone'];
  $school['contact'] = $_POST['contact'];
  $school['fax'] = $_POST['fax'];
  $school['mobile'] = $_POST['mobile'];
      
  foreach ($school as $key => $value)
  {
    if(empty($value))
    {
      $errors[$key] = ucfirst($key).' is required';
    }
  }
  
  if(empty($errors))
  {

    $school['updated_at'] = date('Y-m-d h:i:s');

    $setSchool = new School();
    $setSchool->SetSchool($school);
    
    if(!$setSchool)
    {
        $error = 'School parameters were not set. Try again later';
    }
    else
    {
      unset($school);
      header('Location: set-school-logo.php');
    }
  }
}


?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>School Settings</h3>
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>School Settings</h2>
            <div class="clearfix"></div>
          </div>
          <?php if(!empty($error)): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <strong>Warning!</strong>
              <p><?php echo $error; ?> </p>
            </div>
          <?php endif; ?>
          <?php if(!empty($message)): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <strong>Success!</strong>
              <p><?php echo $message; ?> </p>
            </div>
          <?php endif; ?>
          <div class="x_content">
            <br />
            <form class="form-horizontal form-label-left ajax" method="post" action="">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> School Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst(Sanitizer::XSS($schoolInDb->school_name)); ?>">
                  <span class="fa fa-home form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6"> School Type <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="type" required="required" class="select2_group form-control">
                    <option value="">Select School Type</option>
                    <?php foreach ($types as $type): ?>
                      <option value="<?php echo Sanitizer::XSS($type->school_type_id); ?>" <?php echo $schoolInDb->school_type_id === $type->school_type_id ? 'selected' : ''; ?> ><?php echo ucfirst(Sanitizer::XSS($type->school_type_name)); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> School Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="address" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst(Sanitizer::XSS($schoolInDb->school_address)); ?>">
                  <span class="fa fa-home form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="email" name="email" value="<?php echo Sanitizer::XSS($schoolInDb->school_email); ?>">
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name="phone" class="form-control col-md-7 col-xs-12" required="required" type="tel" value="<?php echo Sanitizer::XSS($schoolInDb->school_phone); ?>">
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name="fax" class="form-control col-md-7 col-xs-12" required="required" type="tel" value="<?php echo Sanitizer::XSS($schoolInDb->school_fax); ?>">
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobile <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="mobile" name="mobile" class="form-control col-md-7 col-xs-12" required="required" type="tel" value="<?php echo Sanitizer::XSS($schoolInDb->school_mobile); ?>">
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">School Contact Person <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="text" name="contact" value="<?php echo ucfirst(Sanitizer::XSS($schoolInDb->school_contact_person)); ?>">
                  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <button type="submit" name="submit" class="btn btn-success">Continue &rarr;</a>
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
