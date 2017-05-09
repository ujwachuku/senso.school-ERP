<?php 

require_once 'common/session-check.php';

if(!isset($_GET['id']))
{
  header('Location: restaurants.php');
}

$id = (int)$_GET['id'];

$page = 'Edit Meal'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';
require_once '../../classes/meal.php';

$errors = [];

$sql = 'SELECT * FROM meals WHERE meal_id = '.$id;
$mealInDb = DB::dbActive()->get($sql)->first();

$restaurants = DB::dbActive()->get('SELECT * FROM restaurants')->results();
$categories = DB::dbActive()->get('SELECT * FROM meal_categories')->results();
$status = DB::dbActive()->get('SELECT * FROM status')->results();

if(isset($_POST['submit']))
{
  if(isset($_POST['name'], $_POST['category'], $_POST['price'], $_POST['restaurant'], $_POST['status']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST
    
    $meal['name'] = $_POST['name'];
    $meal['category'] = $_POST['category'];
    $meal['price'] = $_POST['price'];
    $meal['restaurant'] = $_POST['restaurant'];
    $meal['status'] = $_POST['status'];

    foreach ($meal as $key => $value)
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
    
    //Update meal
    $meal['updated_at'] = $now;

    $query = 'UPDATE meals SET meal_name = ?, meal_category_id = ?, meal_price = ?, meal_restaurant_id = ?, meal_status_id = ?, updated_at = ? WHERE meal_id = '.$id;

    $update = DB::dbActive()->query($query, $meal);

    if(!$update)
    {
        $errors['not created'] = 'Meal was not updated. Try again later';
    }
    else
    {
      unset($meal);
      header('Location: meals.php');
    }
  }
}

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Meal</h3>
      </div>
     
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Meal</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ucfirst($mealInDb->meal_name); ?>">
                  <span class="fa fa-cutlery form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Meal Category <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="category" required="required" class="select2_group form-control">
                    <option value="">Select Meal Category</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?php echo $category->meal_category_id; ?>" <?php echo $mealInDb->meal_category_id === $category->meal_category_id ? 'selected' : ''; ?> ><?php echo ucfirst($category->meal_category_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Price <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="price" class="form-control col-md-7 col-xs-12" required="required" type="text" name="price" value="<?php echo ucfirst($mealInDb->meal_price); ?>" >
                  <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Restaurant <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="restaurant" required="required" class="select2_group form-control">
                    <option value="">Select Restaurant</option>
                    <?php foreach ($restaurants as $restaurant): ?>
                      <option value="<?php echo $restaurant->restaurant_id; ?>" <?php echo $mealInDb->meal_restaurant_id === $restaurant->restaurant_id ? 'selected' : ''; ?> ><?php echo ucfirst($restaurant->restaurant_name); ?></option>
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
                      <option value="<?php echo $state->status_id; ?>" <?php echo $mealInDb->meal_status_id === $state->status_id ? 'selected' : ''; ?> ><?php echo ucfirst($state->status_name); ?> </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="meals.php" class="btn btn-danger">&larr; Back</a>
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
