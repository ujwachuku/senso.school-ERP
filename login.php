<?php

session_start();
ob_start();

require_once 'classes/DB.php';

$currency = DB::dbActive()->single('SELECT currency.currency_name, currency.currency_symbol, currency.currency_position_id
  FROM settings
  INNER JOIN currency
  ON settings.school_currency_id = currency.currency_id')->result();

if($currency)
{
  $_SESSION['currency'] = $currency->currency_symbol;
  $_SESSION['position'] = $currency->currency_position_id;
}

if(isset($_SESSION['loggedIn']) && isset($_SESSION['role']))
{
  switch ($_SESSION['role'])
  {
    case 1:
    case 2:
      header('Location: index.php');
      break;
    case 3:
      header('Location: index-employee.php');
    break;
    case 4:
      header('Location: index-student.php');
    break;
    case 4:
      header('Location: index-parent.php');
    break;
  }

}

$error = '';

if(isset($_POST['login']))
{
  if(isset($_POST['email'], $_POST['password']))
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password))
    {
        $emailInDb = DB::dbActive()->single('SELECT * FROM users WHERE email = '.'"'.$email.'"')->result();

        if(!$emailInDb)
        {
           $error = 'Please check your login details';
        }
        else
        {
            $dbPassword = $emailInDb->password;
            $isValid = password_verify($password,$dbPassword);

            if($isValid && $email === $emailInDb->email)
            {
              $_SESSION['loggedIn'] = 1;
              $_SESSION['email']    = $emailInDb->email;
              $_SESSION['role'] = $emailInDb->user_role_id;

              switch ($_SESSION['role'])
              {
                case 1:
                case 2:
                  header('Location: index.php');
                  break;
                case 3:
                  header('Location: index-employee.php');
                break;
                case 4:
                  header('Location: index-student.php');
                break;
                case 4:
                  header('Location: index-parent.php');
                break;
              }

            }
            else
            {
                $error = 'Please check your login details';
            }
          }
      }
    }
    else
    {
        $error = 'Please check your login details';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | SENSO SCHOOL ERP</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php if(!empty($error)): ?>
              <h2 align="center" style="color:red; font-weight:bold; font-size:18;"><?php echo $error; ?></h2>
            <?php endif; ?>
          <br/>
            <form method="post" action="">
              <h1>Log In </h1>
              <div>
                <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" value="" autocomplete="off" placeholder="Password" required="" />
              </div>
              <div>
                <button name="login" class="btn btn-lg btn-success" type="submit">Log In</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>SENSO SCHOOL ERP</h1>
                  <p>© <?php echo date('Y'); ?> All Rights Reserved. Senso Technology Limited</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
