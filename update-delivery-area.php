<?php 

require_once 'common/session-check.php';

$page = 'Update Restaurant Delivery Areas'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

if(isset($_GET['id']))
{
  $id = $_GET['id'];
}
else
{
  header('Location: delivery-areas.php');
}

$returnUrl = base64_encode($_SERVER['REQUEST_URI']);

$errors = [];
$message = '';

$restaurant = DB::dbActive()->single('SELECT * FROM restaurants WHERE restaurant_id = '.$id)->result();
$citiesInDb = DB::dbActive()->get('SELECT * FROM cities')->results();
$areasInDb = DB::dbActive()->get('SELECT city_id FROM delivery_areas WHERE restaurant_id = '.$id)->results();

$areasTable = DB::dbActive()->get('SELECT delivery_areas.delivery_area_id, cities.city_name FROM delivery_areas INNER JOIN cities ON delivery_areas.city_id = cities.city_id  WHERE delivery_areas.restaurant_id = '.$id)->results();


if(isset($_POST['submit']))
{
  if(isset($_POST['city']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST
    
    $cities = $_POST['city'];

    print_r($cities);

    if(empty($cities))
    {
      $errors[] = 'Cities/Areas are required';
    }

    //Check if restaurant is already set to deliver to the area
    $counter = 0;
    if(!empty($cities))
    {
      foreach ($cities as $city) 
      {
        foreach ($areasInDb as $area) 
        {
          if($area->city_id == $city)
          {
              $counter++;
              
          }
        }
        
      }
      if($counter)
      {
        $errors[] = $counter > 1 ? ' These areas are already selected' : 'This area is already selected';
      }
    }
  }

  if(empty($errors))
  {
      
    $now = date('Y-m-d h:i:s');
    
    $insertCount = 0;
    for($areaCount = 0; $areaCount < count($cities); $areaCount++) 
    {
      $insertAreas = DB::dbActive()->query('INSERT INTO delivery_areas (restaurant_id, city_id, updated_at) VALUES (?,?,?)', [$id, $cities[$areaCount],$now]);
      if($insertAreas)
      {
        $insertCount++;
      }
    }
    
    if($insertCount)
    {
      //$message = $insertCount.' delivery areas have been successfully selected';
      unset($cities);
      header('Location: delivery-areas.php');
    }    
    else
    {
      $errors[] = 'Delivery areas were not created. Try again later';
    } 
    
  }
}


?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Update Restaurant Delivery Areas</h3>
      </div>
     
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Update Restaurant Delivery Areas <small>Select multiple delivery areas by holding either <b>SHIFT</b> or <b>CTRL</b> and clicking the options</small></h2>
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
            <h3><u><?php echo ucfirst($restaurant->restaurant_name); ?></u></h3>
            <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="">
             
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-6">City/Areas <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="city[]" required="required" class="select2_group form-control" multiple="multiple">
                    <?php foreach ($citiesInDb as $city): ?>
                      <option value="<?php echo $city->city_id; ?>" 
                        <?php 
                        foreach ($areasInDb as $area) 
                        {
                          if($area->city_id == $city->city_id)
                          {
                            echo 'selected';
                          }
                        }
                        ?> >
                          <?php echo ucfirst($city->city_name); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="delivery-areas.php" class="btn btn-danger">&larr; Back</a>
                  <button type="submit" name="submit" class="btn btn-success">Add Area</button>
                </div>
              </div>

            </form>
            <br>
            <br>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>City/Area</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($areasTable as $detail): ?>
                  <tr>
                    <td><?php echo ucfirst($detail->city_name); ?></td>
                    <td align="center">
                      <a href="delete-delivery-area.php?id=<?php echo $detail->delivery_area_id; ?>&url=<?php echo $returnUrl; ?>" class="btn btn-danger">Remove</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
  </div>
  <div class="clearfix"></div>
</div>
</div>
<!-- page content -->
<?php require_once 'common/footer.php'; ?>
