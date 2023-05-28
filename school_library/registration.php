
<?php
include ('config/database.php');
  if (!isset($_SERVER["HTTP_USER_AGENT"])) {
    die;
  }
  $query="Select concat(school_number,' ',school_type,' ',city) from school_unit";
  $conn=getDb();
  $result1=mysqli_query($conn,$query);

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
      <title>Register</title>

    </head>
    <body>
        <div class="container" style="border-radius: 1rem; background-color: #DDD9D2; margin-top: 1%;">
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-5">
              <div class="card" style="border-radius: 2rem; margin-top: 5%; margin-bottom: 5%; text-align: center;"> 
                <div class="card-body text-center">
                  <img
                    src="library.jpg"
                    vspace="15"
                    hspace="15"
                    width="60"
                  >
                  <form id="registrationform" method="POST" action="register_user.php" autocomplete="off">
                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
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

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
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

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="text"
                        autocomplete="off"
                        id="first_name"
                        placeholder="First Name"
                        name='first_name'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="text"
                        autocomplete="off"
                        id="laast_name"
                        placeholder="Last Name"
                        name='last_name'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <!-- <label for="birth_date">Date of Birth:</label> -->
                      <input type="text" 
                        placeholder="Date of Birth"
                        onfocus="(this.type='date')"
                        autocomplete="off"
                        id="birth_date"
                        name='birth_date'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="text"
                        autocomplete="off"
                        id="address"
                        placeholder="address"
                        name='address'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="text"
                        autocomplete="off"
                        id="email"
                        placeholder="Email"
                        name='email'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <input
                        type="text"
                        autocomplete="off"
                        id="phone_number"
                        placeholder="Phone Number"
                        name='phone_number'
                        class="form-control form-control-lg align-self-center"
                        value=""
                        required="required"
                      />
                    </div>

                    <div class="form-outline mb-2" style="margin-left: 20%; margin-right: 20%;">
                      <select name="school" class="form-control" id="school">
                          <?php while ($row1=mysqli_fetch_array($result1)):;?>
                          <option>
                              <?php echo $row1[0];?>
                          </option>
                          <?php endwhile;?>
                      </select>
                    </div>

                    <div class="form-check" style="margin-left: 40%; margin-right: 40%;">
                      <input class="form-check-input" 
                        type="radio" 
                        value="student" 
                        id="student"
                        name="status"
                      />
                      <label class="form-check-label" for="flexCheckDefault">
                                student
                      </label>
                    </div>

                    <div class="form-check" style="margin-left: 40%; margin-right: 40%;">
                      <input class="form-check-input" 
                        type="radio" 
                        value="teacher" 
                        id="teacher"
                        name="status"
                      />
                      <label class="form-check-label" for="flexCheckDefault">
                                teacher
                      </label>
                    </div>

                    <button style="margin-top:2%"
                      class="btn btn-secondary btn-lg btn-dark"
                      type="submit"
                    >
                      Register
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
  </body>
</html>
