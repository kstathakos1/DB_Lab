
<?php

  if (!isset($_SERVER["HTTP_USER_AGENT"])) {
    die;
  }


  session_start();
  if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }

?>

<html>
    <head>
      <!-- Import css and js packages -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/custom.css?<?=time()?>">
      <link rel="stylesheet" href="css/fontawesome.min.css">
      <link rel="stylesheet" href="css/all.min.css">

      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="css/jquery-ui.css">
      <script src="js/jquery-1.10.2.js"></script>
      <script src="js/jquery-ui.js"></script>

      <link rel="shortcut icon" href="library.jpg" type="image/x-icon">
      <title>Login</title>

    </head>
    <body>
        <div class="container" style="border-radius: 1rem; background-color: #DDD9D2; margin-top: 3.5%;">
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-5">
              <div class="card shadow-2-strong" style="border-radius: 1rem; margin-top: 20%; margin-bottom: 20%; text-align: center;"> 
                <div class="card-body text-center">
                  <img
                    src="library.jpg"
                    vspace="30"
                    hspace="15"
                    width="120"
                  >
                  <?php if (isset($_GET['wrongCredentials'])) echo '<div class="alert alert-danger text-center" role="alert"> Wrong credentials. Please try again.</div>' ?>
                  <form id="loginform" method="POST" action="authenticate.php" autocomplete="on">
                    <div class="form-outline mb-4" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="text"
                        autocomplete="off"
                        id="username"
                        placeholder="username"
                        name='username'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-4" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="password"
                        autocomplete="on"
                        id="password"
                        placeholder="password"
                        name='password'
                        class="form-control form-control-lg"
                        value=""
                        required="required"
                      />
                    </div>

                    <button
                      class="btn btn-secondary btn-lg btn-block"
                      type="submit"
                    >
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
  </body>
</html>
