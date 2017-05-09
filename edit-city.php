<?php 

require_once 'common/session-check.php';

if(!isset($_GET['id']))
{
  header('Location: cities.php');
}

$id = (int)$_GET['id'];

$page = 'Edit City';

require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$errors = [];

$sql = 'SELECT * FROM cities WHERE city_id = '.$id;
$cityInDb = DB::dbActive()->get($sql)->first();

if(isset($_POST['submit']))
{
  if(isset($_POST['name']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST
    
    $city['name'] = $_POST['name'];
    
    if(empty($city['name']))
    {
      $errors[] = 'City name is required';
    }
  }

  if(empty($errors))
  {
      
    $now = date('Y-m-d h:i:s');
    $city['updated_at'] = $now;

    $sql = 'UPDATE cities SET city_name = ?, updated_at = ? WHERE city_id = '.$id;
    $update = DB::dbActive()->query($sql, $city);

    if(!$update)
    {
        $errors[] = 'City was not updated. Try again later';
    }
    else
    {
      unset($city);
      header('Location: cities.php');
    }
  }
}

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit City</h3>
      </div>
     
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit City</h2>
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
          <div class="x_content">
            <br />
            <form method="post" action="" class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst($cityInDb->city_name); ?>" >
                  <span class="fa fa-globe form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="cities.php" class="btn btn-danger">&larr; Back</a>
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
