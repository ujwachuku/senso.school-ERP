<?php 

require_once 'common/session-check.php';

if(!isset($_GET['id']))
{
  header('Location: restaurants.php');
}

$id = (int)$_GET['id'];

$page = 'Edit Restaurant'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';
require_once '../../classes/Restaurant.php';

$errors = [];

$sql = 'SELECT * FROM restaurants WHERE restaurant_id = '.$id;
$restaurantInDb = DB::dbActive()->get($sql)->first();

$categories = DB::dbActive()->get('SELECT * FROM restaurant_categories')->results();
$cities = DB::dbActive()->get('SELECT * FROM cities')->results();
$vendors = DB::dbActive()->get('SELECT * FROM users WHERE user_role_id = 3')->results();
$status = DB::dbActive()->get('SELECT * FROM status')->results();

if(isset($_POST['submit']))
{
  if(isset($_POST['name'], $_POST['category'], $_POST['address'], $_POST['city'], $_POST['email'], $_POST['phone'], $_POST['status'], $_POST['description'], $_POST['min-order'], $_POST['delivery'], $_POST['open-time'], $_POST['close-time'], $_POST['vendor']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST
    
    $restaurant['name'] = $_POST['name'];
    $restaurant['category'] = $_POST['category'];
    $restaurant['address'] = $_POST['address'];
    $restaurant['city'] = $_POST['city'];
    $restaurant['email'] = $_POST['email'];
    $restaurant['phone'] = $_POST['phone'];
    $restaurant['status'] = $_POST['status'];
    $restaurant['description'] = $_POST['description'];
    $restaurant['open-time'] = $_POST['open-time'];
    $restaurant['close-time'] = $_POST['close-time'];
    $restaurant['vendor'] = $_POST['vendor'];
    $restaurant['min-order'] = $_POST['min-order'];
    $restaurant['delivery'] = $_POST['delivery'];

    foreach ($restaurant as $key => $value)
    {
      if(empty($value))
      {
        $errors[$key] = ucfirst($key).' is required';
      }
    }
  }

  if(empty($errors))
  {
      
    $now = date('Y-m-d h:i:s');
    
    //Update restaurant
    $restaurant['updated_at'] = $now;

    $query = 'UPDATE restaurants SET restaurant_name = ?, restaurant_category_id = ?, restaurant_address = ?, restaurant_city_id = ?, restaurant_email = ?, restaurant_phone = ?, restaurant_status_id = ?, restaurant_description = ?, open_time = ?, close_time = ?, vendor_id = ?, minimum_order = ?, estimated_delivery_time = ?, updated_at = ? WHERE restaurant_id = '.$id;

    $update = DB::dbActive()->query($query, $restaurant);

    if(!$update)
    {
        $errors['not created'] = 'Restaurant was not created. Try again later';
    }
    else
    {
        //$message = 'restaurant has been succesfully created.';
        unset($restaurant);
        header('Location: restaurants.php');
    }
  }
}


?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Restaurant</h3>
      </div>
     
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Restaurant</h2>
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
            <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst($restaurantInDb->restaurant_name); ?>">
                  <span class="fa fa-cutlery form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Restaurant Category <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="category" required="required" class="select2_group form-control">
                    <option value="">Select Restaurant Category</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?php echo $category->rest_category_id; ?>" <?php echo $restaurantInDb->restaurant_category_id === $category->rest_category_id ? 'selected' : ''; ?> ><?php echo ucfirst($category->rest_category_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="address" name="address" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst($restaurantInDb->restaurant_address); ?>">
                  <span class="fa fa-home form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">City <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="city" required="required" class="select2_group form-control">
                    <option value="">Select City</option>
                    <?php foreach ($cities as $city): ?>
                      <option value="<?php echo $city->city_id; ?>" <?php echo $restaurantInDb->restaurant_city_id === $city->city_id ? 'selected' : ''; ?> ><?php echo ucfirst($city->city_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="email" class="form-control col-md-7 col-xs-12" required="required" type="email" name="email" value="<?php echo ucfirst($restaurantInDb->restaurant_email); ?>">
                  <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="phone" name="phone" class="form-control col-md-7 col-xs-12" required="required" type="tel" value="<?php echo ucfirst($restaurantInDb->restaurant_phone); ?>">
                  <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name="description" class="form-control col-md-7 col-xs-12" required="required" ><?php echo ucfirst($restaurantInDb->restaurant_description); ?></textarea>
                  <span class="fa fa-list-alt form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Opening Time <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="time" name="open-time" value="<?php echo $restaurantInDb->open_time; ?>">
                  <span class="fa fa-clock-o form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Closing Time <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="time" name="close-time" value="<?php echo $restaurantInDb->close_time; ?>">
                  <span class="fa fa-clock-o form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Minimum Order Value <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="number" min="0" step="any" name="min-order" value="<?php echo ucfirst($restaurantInDb->minimum_order); ?>" />
                  <span class="fa fa-usd form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Estimated Time to Delivery <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="number" min="1" step="any" name="delivery" value="<?php echo ucfirst($restaurantInDb->minimum_order); ?>" />
                  <span class="fa fa-truck form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Vendor <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="vendor" required="required" class="select2_group form-control">
                    <option value="">Select Vendor</option>
                    <?php foreach ($vendors as $vendor): ?>
                      <option value="<?php echo $vendor->user_id; ?>" <?php echo $restaurantInDb->vendor_id === $vendor->user_id ? 'selected' : ''; ?> ><?php echo ucfirst($vendor->fname).' '.ucfirst($vendor->lname); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Status <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="status" required="required" class="select2_group form-control">
                    <option value="">Select Status</option>
                    <?php foreach ($status as $state): ?>
                      <option value="<?php echo $state->status_id; ?>" <?php echo $restaurantInDb->restaurant_status_id === $state->status_id ? 'selected' : ''; ?> ><?php echo ucfirst($state->status_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="restaurants.php" class="btn btn-danger">&larr; Back</a>
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
