<?php 

require_once 'common/session-check.php';
require_once 'common/admin-check.php';

$page = 'Manage Social Media'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php'; 
require_once '../../classes/DB.php';

$sql = 'SELECT * FROM social';

$socialInDb = DB::dbActive()->get($sql)->first();

if(isset($_POST['submit']))
{
  if(isset($_POST['facebook'], $_POST['twitter'], $_POST['instagram']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST
    
    $social['facebook'] = $_POST['facebook'];
    $social['twitter'] = $_POST['twitter'];
    $social['instagram'] = $_POST['instagram'];
  }

  $now = date('Y-m-d h:i:s');
    
  //Update social
  $social['updated_at'] = $now;

  $query = 'UPDATE social SET facebook = ?, twitter = ?, instagram = ?, updated_at = ? WHERE social_id = 1 ';

  $update = DB::dbActive()->query($query, $social);

  if(!$update)
  {
      $error = 'Meal was not updated. Try again later';
  }
  else
  {
    unset($social);
    $message = 'Social media URLs have been updated';
  }
  
}

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Manage Social Media</h3>
      </div>
     
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Manage Social Media</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
             <?php if(!empty($message)): ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <strong><?php echo ucfirst($message); ?></strong>
              </div>
            <?php endif; ?>
            <?php if(!empty($error)): ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <strong><?php echo ucfirst($error); ?></strong>
              </div>
            <?php endif; ?>
            <br />
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook URL</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="facebook" name="facebook" class="form-control col-md-7 col-xs-12" value="<?php echo $socialInDb->facebook; ?>">
                  <span class="fa fa-facebook form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Twitter URL</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="twitter" name="twitter" class="form-control col-md-7 col-xs-12" value="<?php echo $socialInDb->twitter; ?>">
                  <span class="fa fa-twitter form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Instagram URL</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="instagram" name="instagram" class="form-control col-md-7 col-xs-12" value="<?php echo $socialInDb->instagram; ?>">
                  <span class="fa fa-instagram form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
