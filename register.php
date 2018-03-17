
<?php
  require('connect.php');
  if(isset($_POST['submit'])){

    $err = array(
      "f_name" => "",
      "l_name" => "",
      "code_id" => "",
      "copy_file" => "",
      "username" => "",
      "password" => "",
      "birth_date" => "",
      "answer_1" => "",
      "answer_2" => "",
      "answer_3" => "",
      "e-email" => "",
    );
    $special_char = "* Special character is not allowed.";
    $please_insert_i = "* Please insert information.";
    $illegal_e = "#$%^&*()+=[]';,/{}|:<>?~";
    $illegal_n = "#$%^&*()+=[]';,./{}|:<>?~-_";
    $illegal = "#$%^&*()+=[]';,./{}|:<>?~@";

    //First name check
    if(isset($_POST['name']) && $_POST['name'] != null){
      if(strpbrk($_POST['name'], $illegal_n)){
        $err['f_name'] = $special_char;
      }else{
          $err['f_name'] = "";
      }
    }else{
      $err['f_name'] = $please_insert_i;
    }

    //Last name check
    if(isset($_POST['surname']) && $_POST['surname'] != null){
      if(strpbrk($_POST['surname'], $illegal_n)){
        $err['l_name'] = $special_char;

      }else{
          $err['l_name'] ="";
      }
    }else{
      $err['l_name'] = $please_insert_i;
    }


    //National ID or Passport ID check
    if(isset($_POST['code-id']) && $_POST['code-id'] != null){
        if(!preg_match('/^[1-9][0-9]*$/', $_POST['code-id'])) {
           $err['code_id'] = $special_char;
        }else{
          $err['code-id'] = "";
        }
    }else{
      $err['code_id'] = $please_insert_i;

    }


    //File check
    if(isset($_FILES['file']) && $_FILES['file']['name'] != null){
      $file = $_FILES['file'];
      $filename = $file['name'];
      $explode = explode('.', $filename);
      if ($explode != null){
        $file_ext = strtolower(end($explode));
      }
      $file_name_new = "";

      $allowed = array('jpg', 'jpeg', 'png');
      if(in_array($file_ext, $allowed)){
        if($file['error'] === 0){
          if($file['size'] < 5000000){
            $newfilename = uniqid('', true).".".$file_ext;
            $file_name_new = $newfilename;
            $file_destination = 'uploads/'.$newfilename;
            $err['copy_file'] = "";
          }else{
            $err['copy_file'] = "* Too much file size.";
          }
        }else{
          $err['copy_file'] = "* Error occured.";
        }
      }else{
        $err['copy_file'] = "* File extension should be jpg, jpeg or png.";
      }
    }else{
      $err['copy_file'] = "* Please insert copy national id or passport id file.";
    }


    //Username check
    if(isset($_POST['username']) && $_POST['username'] != null){
      if(strpbrk($_POST['username'], $illegal)){
       $err['username'] = $special_char."except \"-\" or \"_\".";
      }else{
        $err['username'] = "";
      }
    }else{
      $err['username'] = $please_insert_i;
    }


    //Password check
    if(isset($_POST['password']) && $_POST['password'] != null){
      if(strpbrk($_POST['password'], $illegal)){
       $err['password'] = $special_char."except \"-\" or \"_\".";
      }else{
        $err['password'] = "";
      }
    }else{
      $err['password'] = $please_insert_i;
    }
    


    //Birth data check
    if(isset($_POST['birth-date']) && $_POST['birth-date'] != NULL){
      if(strpbrk($_POST['birth-date'], $illegal)){
        $err['birth_date'] = "You birth date maybe wrong.";
      }
    }else{
      $err['birth_date'] = "* Please insert date.";
    }
    

    //Answer1 check
    if(isset($_POST['first-answer']) && $_POST['first-answer'] != null){
      if(strpbrk($_POST['first-answer'], $illegal)){
        $err['answer_1'] = $special_char;
      }else{
        $err['answer_1'] = "";
      }
    }else{
      $err['answer_1'] = $please_insert_i;
    }

    //Answer2 check
    if(isset($_POST['second-answer']) && $_POST['second-answer'] != null){
      if(strpbrk($_POST['second-answer'], $illegal)){
        $err['answer_2'] = $special_char;
      }else{
        $err['answer_2'] = "";
      }
    }else{
      $err['answer_2'] = $please_insert_i;
    }


    //Answer3 check
    if(isset($_POST['third-answer']) && $_POST['third-answer'] != null){
      if(strpbrk($_POST['third-answer'], $illegal)){
        $err['answer_3'] = $special_char;
      }else{
        $err['answer_3'] ="";
      }
    }else{
      $err['answer_3'] = $please_insert_i;
    }


    //Email
    if(isset($_POST['email']) && $_POST['email'] != null){
      if(strpbrk($_POST['email'], $illegal_e)){
        $err['e-email'] = $special_char;
      }else{
          $err['e-email'] ="";
      }
    }else{
      $err['e-email'] = $please_insert_i;
    }

    $i = 0;
    foreach ($err as $key => $value) {
      if($value != ""){
        $i++;
      }
    }
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $n_id = $_POST['code-id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $birth_date = $_POST['birth-date'];

    $first_q = $_POST['first-question'];
    $second_q = $_POST['second-question'];
    $third_q = $_POST['third-question'];

    $first_a = $_POST['first-answer'];
    $second_a = $_POST['second-answer'];
    $third_a = $_POST['third-answer'];

    $email = $_POST['email'];
    if(!$i){
      $subject = "Test send email";
      $header = "From: wasitthaphon@gmail.com";
      $message = "My Body & My Desctription";
      $flag = @mail($email, $subject, $message, $header);
      if($flag){
        $sql_str = "INSERT INTO user VALUES (NULL, '$name', '$surname', '$n_id', '$file_name_new', '$username', '$password', '$birth_date', '$first_q', '$first_a', '$second_q', '$second_a', '$third_q', '$third_a', '$email', 0, 0)";
        $conn->exec($sql_str);
        move_uploaded_file($file['tmp_name'], $file_destination);
        header("Location: success.php");
      }else{
        echo "email can not send.";
      }
    }

  }else{
    $err = array(
      "f_name" => "",
      "l_name" => "",
      "code_id" => "",
      "copy_file" => "",
      "username" => "",
      "password" => "",
      "birth_date" => "",
      "answer_1" => "",
      "answer_2" => "",
      "answer_3" => "",
      "e-email" => "",
    );
  }
  //print_r($err);
?>

<!DOCTYPE html>
<html>
<head>
  <title>ธ.นำธรรมดี</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit"off">
  <link href="https://fonts.googleapis.com/css?family=Pattaya" rel="stylesheet">
  <link href="css/bootstrap-grid.css" rel="stylesheet">
  <link href="css/bootstrap-reboot.css" rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link href="css/main.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/carousel.css">
      <!-- เพิ่ม --> <link href="https://fonts.googleapis.com/css?family=Maitree|Trirong" rel="stylesheet">
</head>
<body class="Backg-body">

  <main role="main">
   <!-- แก้ไข -->
    <header class="header_Bg">
      <div class="navbar-header width">
        <img class="img left" src="img/Logo1.png" alt="Logo1">
        <spen class="right">
            <div><a class="btn-link" href="#">Sign In</a></div>
            <div><a class="btn-link" href="register.php">Register</a></div>
        </spen>
      </div>   
    </header>

    <nav id="mainnav">
      <div class="width">
          <ul>
              <li class="dropdown">
                  <button class="dropbtn"><a href="index.php">Home</a></button>
                  <div class="dropdown-content">
                      <a href="news1.html">News and   Announcement</a>

                  </div>

              </li>
              <li><a href="#">Knowledge sources</a></li>
              <li><a href="#">Events</a></li>
              <li><a href="#">About us</a></li>
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
  <div class="register_container">
    <h3 style="text-align: center; margin-top: 2rem;">Registration</h3><br><br>

    <form id="register_form" class="font-Tri" method="post" enctype="multipart/form-data">

      <!-- First name -->
      <div class="form-group">
        <div class="row">
          <label for="name" style="margin-top: 5px;">First name</label>
          <div class="col">
            <input type="text" class="form-control row" name="name" id="name" aria-describedby="name-help" autocomplete="off"  >
            <small id="name-help" class="form-text row" style="color: red;">
              <?php
                echo $err['f_name'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- Last name -->
      <div class="form-group">
        <div class="row">
          <label for="surname" style="margin-top: 5px;">Last name</label>
          <div class="col">
            <input type="text" class="form-control row" name="surname" id="surname" aria-describedby="surname-help" autocomplete="off">
           <small id="surname-help" class="form-text row" style="color: red;">
             <?php
              echo $err['l_name'];
             ?>
           </small>
         </div>
        </div>
      </div>

      <!-- passport-id or national-id -->
      <div class="form-group">
        <div class="row">
          <label for="code-id" style="margin-top: 0px;">National ID or <br> passport ID</label>
          <div class="col">
            <input type="text" class="form-control row" name="code-id" id="code-id" aria-describedby="code-id-help" autocomplete="off">
            <small id="code-id-help" style="color: red;" class="form-text row">
              <?php
                echo $err['code_id'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- Copy national-id or passport-id file -->
      <div class="form-group" style="margin-top: 10px;">
        <label for="file-upload">Copy national ID or passport ID file</label>
        <input type="file" name="file" class="form-control-file" id="file-upload" aria-describedby="upload-help"
        >
        <small id="upload-help" class="form-text" style="color: red;">
          <?php
            echo $err['copy_file'];
          ?>
        </small>
      </div>


      <!-- username -->
      <div class="form-group">
        <div class="row">
          <label for="username" style="margin-top: 5px;">Username</label>
          <div class="col">
            <input type="text" class="form-control row" name="username" id="username" aria-describedby="username-help" placeholder="username" autocomplete="off" >
            <small id="username-help" class="form-text row" style="color: red;">
              <?php
                echo $err['username'];
              ?>
            </small>
          </div>
        </div>
      </div>


      <!-- password -->
      <div class="form-group">
        <div class="row">
          <label for="password" style="margin-top: 5px;">Password</label>
          <div class="col">
            <input type="password" class="form-control row" name="password" id="password" aria-describedby="password-help" placeholder="password" autocomplete="off" >
            <small id="password-help" class="form-text row" style="color: red">
              <?php
                echo $err['password'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- Birth date -->
      <div class="form-group">
        <div class="row">
          <label for="birth-date" style="margin-top: 5px">Birth date</label>
          <div class="col">
            <input type="date" class="form-control row" name="birth-date" id="birth-date" aria-describedby="birth-date-help" placeholder="birth date" autocomplete="off" >
            <small id="birth-date-help" class="form-text row" style="color: red;">
              <?php
                echo $err['birth_date'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- First question -->
      <div class="form-row form-group">
        <div class="col-6">
          <label for="first-question">Please select one question</label>
          <select class="custom-select" name="first-question">

            <!-- insert question here -->
            <option selected value="1">ฮีโร่สุดโปรดของคุณชื่ออะไร</option>
            <option value="2">เพื่อบ้านคนแรกของคุณชื่ออะไร</option>

          </select>
        </div>

        <!-- First answer -->
        <div class="col-6">
          <label for="first-answer">Answer</label>
          <input type="text" class="form-control" name="first-answer" id="first-answer" autocomplete="off" >
        </div>
        <small id="first-question-answer-help" class="form-text" style="color: red;">
          <?php
            echo $err['answer_1'];
          ?>
        </small>
      </div>

      <!-- Second question and answer -->
      <div class="form-row form-group">
        <div class="col-6">
          <label for="second-question">Please select one question</label>
          <select class="custom-select" name="second-question">

            <!-- insert question here -->
            <option selected value="1">ฮีโร่สุดโปรดของคุณชื่ออะไร</option>
            <option value="2">เพื่อบ้านคนแรกของคุณชื่ออะไร</option>

          </select>
        </div>

        <!-- Second answer -->
        <div class="col-6">
          <label for="second-answer">Answer</label>
          <input type="text" class="form-control" name="second-answer" id="second-answer" autocomplete="off" >
        </div>
        <small id="second-question-answer-help" class="form-text" style="color: red;">
          <?php
            echo $err['answer_2'];
          ?>
        </small>
      </div>

      <!-- Third question -->
      <div class="form-row form-group">
        <div class="col-6">
          <label for="third-question">Please select one question</label>
          <select class="custom-select" name="third-question">

            <!-- insert question here -->
            <option selected value="1">ฮีโร่สุดโปรดของคุณชื่ออะไร</option>
            <option value="2">เพื่อบ้านคนแรกของคุณชื่ออะไร</option>

          </select>
        </div>

        <!-- Third answer -->
        <div class="col-6">
          <label for="third-answer">Answer</label>
          <input type="text" class="form-control" name="third-answer" id="third-answer" autocomplete="off" >
        </div>
        <small id="third-question-answer-help" class="form-text" style="color: red;">
          <?php
            echo $err['answer_3'];
          ?>
        </small>
      </div>

      <!-- email -->
      <div class="form-group" style="margin-top: 20px;">
        <div class="row">
          <label for="email" style="margin-top: 5px;">Email</label>
          <div class="col">
            <input type="email" class="form-control row" name="email" id="email" aria-describedby="email-help" autocomplete="off" >
            <small id="email-help" style="color: red;" class="form-text row" >
              <?php
                echo $err['e-email'];
              ?>
            </small>
          </div>
        </div>
      </div>



      <center>
        <!-- Agreement -->
        <input type="checkbox" name="accept-agreement" value="1" required> I agree <a href="#" style="text-decoration:"offne;">Policy<a>
        <br><br>
        <button id="submit" class="btn btn-primary" name="submit">Register</button>
      </center>
    </form>
  </div>



  <footer id="footer" class="text-center" style="margin-top: 3rem;">
    <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน ธ.นำธรรมดี </span> </div>
    <div class="font-color1"> saharuthi_j@kkumail.com </div>
  </footer>
  <!-- Script -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>