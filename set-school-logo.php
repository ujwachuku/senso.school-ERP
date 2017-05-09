<?php 

require_once 'common/session-check.php';

$page = 'Set School Logo'; 
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once 'classes/DB.php';
require_once 'classes/School.php';

$errors = [];
$message = '';

if(isset($_POST['submit']))
{
  if(isset($_FILES['logo']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST
    
    if(!empty($_FILES['logo']))
    {
      
      $fileName = $_FILES['logo']['name'];
      $fileSize = $_FILES['logo']['size'];
      $fileTmp = $_FILES['logo']['tmp_name'];
      $fileError = $_FILES['logo']['error'];

      $fileExt = explode('.',$fileName);
      $fileNameFirst = $fileExt[0];
      $fileExt = end($fileExt);

      $allowed = ['jpg','jpeg','png','gif'];

      if(in_array($fileExt, $allowed))
      {
        if($fileError === 0)
        {
          if($fileSize <= 2097152)
          {
            $logo['name'] = $fileNameFirst.'-'.date('Y-m-d-h-i-s').'.'.$fileExt;
            $fileDestination = 'images/uploads/school/'.$logo['name'];

            if(move_uploaded_file($fileTmp, $fileDestination))
            {
              
              $logo['updated_at'] = date('Y-m-d h:i:s');
        
              $update = new School();
              $update->SetLogo($logo);

              if(!$update)
              {
                $error[] = 'School logo was not updated. Try again later';
              }
              else
              {
                $message = 'School settings have been succesfully updated.';
                unset($logo);
              }
              
            }
          }
          else
          {
            $errors[] = 'File is too large (> 2MB)';
          }
        }
        else
        {
          $errors[] = 'File upload error';
        }
      }
      else
      {
        $errors[] = 'File format not supported OR Blank upload';
      }
    }
  }  
  
}


?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Set School Logo</h3>
      </div>
     
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Set School Logo</h2>
            <div class="clearfix"></div>
          </div>
          <?php if(!empty($errors)): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <strong>Warning!</strong> 
              <?php foreach($errors as $error): ?>
                <p><?php echo $error; ?> </p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <?php if(!empty($message)): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <strong>Success!</strong> 
              <p><?php echo $message; ?> </p>
            </div>
          <?php endif; ?>
          <div class="x_content">
            <br />
            <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="" enctype="multipart/form-data">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Image <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input class="form-control col-md-7 col-xs-12" required="required" type="file" name="logo" />
                  <span class="fa fa-upload form-control-feedback right" aria-hidden="true"></span>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="set-school.php" class="btn btn-danger">&larr; Back</a>
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
