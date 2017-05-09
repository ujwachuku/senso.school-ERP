<?php

require_once 'common/session-check.php';
require_once 'common/admin-check.php';

$page = 'Manage Store Currency';
require_once 'common/header.php';
require_once 'common/set-sidebar.php';
require_once 'common/top-nav.php';
require_once '../../classes/DB.php';

$error = '';

$sql = 'SELECT * FROM currency';

$currencies = DB::dbActive()->get($sql)->results();

$settings = DB::dbActive()->get('SELECT * FROM settings WHERE settings_id = 1')->first();

if(isset($_POST['submit']))
{
  if(isset($_POST['currency']))
  {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //Sanitize $_POST

    $currency['currency'] = $_POST['currency'];
  }
  else
  {
    $error = 'Please select store currency';
  }

  if(empty($error))
  {
    $query = 'UPDATE settings SET store_currency_id = ? WHERE settings_id = 1 ';

    $update = DB::dbActive()->query($query, $currency);

    if(!$update)
    {
        $error = 'Currency settings were not updated. Try again later';
    }
    else
    {
      $setCurrency = DB::dbActive()->single('SELECT currency_id, currency_position_id FROM currency WHERE currency_id = '.$currency['currency'])->result();
      $_SESSION['currency'] = $setCurrency->currency_symbol;
      $_SESSION['position'] = $setCurrency->currency_position_id;

      unset($currency);
      header('Location: currency.php');
    }
  }


}

?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Manage Store Currency</h3>
      </div>

    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Manage Store Currency</h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-6">Store Currency <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <select name="currency" required="required" class="select2_group form-control">
                    <option value="">Select Currency</option>
                    <?php foreach ($currencies as $bill): ?>
                      <option value="<?php echo $bill->currency_id; ?>"
                      <?php
                        if(isset($currency['currency']) && $currency['currency'] === $settings->store_currency_id)
                        {
                          echo 'selected';
                        }
                        elseif($bill->currency_id === $settings->store_currency_id)
                        {
                          echo 'selected';
                        }
                        else
                        {
                          echo '';
                        }
                      ?> >
                      <?php echo ucfirst($bill->currency_name); ?>

                      </option>
                    <?php endforeach; ?>
                  </select>
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
