
<?php
  require('connect.php');
  if(isset($_POST['submit'])){

    $err = array(
      "err_occurred" => 0,
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
      "email" => "",
    );
    $illegal = "#$%^&*()+=[]';,./{}|:<>?~";

    //First name check
    if(isset($_POST['name'])){
      if(strpbrk($_POST['name'], $illegal)){
        $err['f_name'] = "Special character is not allowed except \'-\' or \'_\'";
      }
    }

    //Last name check
    if(isset($_POST['surname'])){
      if(strpbrk($_POST['surname'], $illegal)){
        $err['l_name'] = "Special character is not allowed except \'-\' or \'_\'";
      }
    }


    //File check
    $file = $_FILES['file'];
    $filename = $file['name'];
    $file_ext = strtolower(end(explode('.', $filename)));
    $file_name_new = "";

    $allowed = array('jpg', 'jpeg', 'png');
    if(in_array($file_ext, $allowed)){
      if($file['error'] === 0){
        if($filw['size'] < 5000){
          $newfilename = uniqid('', true).".".$file_ext;
          $file_name_new = $newfilename;
          $file_destination = 'uploads/'.$newfilename;
          $sql_str = "INSERT INTO user VALUES (NULL, '$name', '$surname', '$n_id', '$file_name_new', '$username', '$password', '$birth_date', '$first_q', '$first_a', '$second_q', '$second_a', '$third_q', '$third_a')";
          $conn->exec($sql_str);
          move_uploaded_file($file['tmp_name'], $file_destination);
          echo "<script><alert> Success </alert></script>";
          header("Location: register.php?success");
        }else{
          echo "<script><alert> Size too many </alert></script>";
        }
      }else{
        echo "<script><alert> Error! </alert></script>";
      }
    }else{
      echo "<script><alert> Wrong file extension </alert><script>";
    }


    



    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $n_id = $_POST['national-id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $birth_date = $_POST['birth-date'];

    $first_q = $_POST['first-question'];
    $second_q = $_POST['second-question'];
    $third_q = $_POST['third-question'];

    $first_a = $_POST['first-answer'];
    $second_a = $_POST['second-answer'];
    $third_a = $_POST['third-answer'];




    

  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>ธ.นำธรรมดี</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
              <li><a href="index.php">Home</a></li>
              <li><a href="news_form.php">News and Announcements</a></li>
              <li><a href="#">Knowledge sources</a></li>
              <li><a href="#">Events</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Profile</a></li>
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
  <div class="register_container">
    <h3 style="text-align: center; margin-top: 2rem;">สมัครสมาชิก</h3><br><br>

    <form id="register_form" class="font-Tri" method="post" enctype="multipart/form-data">

      <!-- First name -->
      <div class="form-group">
        <div class="row">
          <label for="name" style="margin-top: 5px;">First name</label>
          <div class="col">
            <input type="text" class="form-control row" name="name" id="name" aria-describedby="name-help" autocomplete="no" required >
            <small id="name-help" class="form-text text-muted row">Test text.</small>
          </div>
        </div>
      </div>

      <!-- Last name -->
      <div class="form-group">
        <div class="row">
          <label for="surname" style="margin-top: 5px;">Last name</label>
          <div class="col">
            <input type="text" class="form-control row" name="surname" id="surname" aria-describedby="surname-help" autocomplete="no" required>
           <small id="surname-help" class="form-text text-muted row">Test text.</small>
         </div>
        </div>
      </div>

      <!-- passport-id or national-id -->
      <div class="form-group">
        <div class="row">
          <label for="code-id" style="margin-top: 0px;">National ID or <br> passport ID</label>
          <div class="col">
            <input type="text" class="form-control row" name="code-id" id="code-id" aria-describedby="code-id-help" autocomplete="no" required>
            <small id="code-id-help" class="form-text text-muted row">Test text.</small>
          </div>
        </div>
      </div>

      <!-- Copy national-id or passport-id file -->
      <div class="form-group" style="margin-top: 10px;">
        <label for="file-upload">Copy national ID or passport ID file</label>
        <input type="file" name="file" class="form-control-file" id="file-upload" aria-describedby="upload-help"
        required>
        <small id="upload-help" class="form-text text-muted">Test text.</small>
      </div>


      <!-- username -->
      <div class="form-group">
        <div class="row">
          <label for="username" style="margin-top: 5px;">Username</label>
          <div class="col">
            <input type="text" class="form-control row" name="username" id="username" aria-describedby="username-help" placeholder="username" required>
            <small id="username-help" class="form-text text-muted row">Test text.</small>
          </div>
        </div>
      </div>


      <!-- password -->
      <div class="form-group">
        <div class="row">
          <label for="password" style="margin-top: 5px;">Password</label>
          <div class="col">
            <input type="text" class="form-control row" name="password" id="password" aria-describedby="password-help" placeholder="password" pattern="[A-Za-z0-9]{5,16}" required>
            <small id="password-help" class="form-text text-muted row">Test text.</small>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="row">
          <label for="birth-date" style="margin-top: 5px">Birth date</label>
          <div class="col">
            <input type="date" class="form-control row" name="birth-date" id="birth-date" aria-describedby="birth-date-help" placeholder="birth date" required>
            <small id="birth-date-help" class="form-text text-muted row">Test text.</small>
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
          <input type="text" class="form-control" name="first-answer" id="first-answer" autocomplete="no" required>
        </div>
        <small id="first-question-answer-help" class="form-text text-muted">Test text.</small>
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
          <input type="text" class="form-control" name="second-answer" id="second-answer" autocomplete="no" required>
        </div>
        <small id="second-question-answer-help" class="form-text text-muted">Test text.</small>
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
          <input type="text" class="form-control" name="third-answer" id="birth-date" autocomplete="no" required>
        </div>
        <small id="third-question-answer-help" class="form-text text-muted">Test text.</small>
      </div>

      <!-- email -->
      <div class="form-group" style="margin-top: 20px;">
        <div class="row">
          <label for="email" style="margin-top: 5px;">Email</label>
          <div class="col">
            <input type="text" class="form-control row" name="email" id="email" aria-describedby="email-help" autocomplete="no" required >
            <small id="email-help" class="form-text text-muted row">Test text.</small>
          </div>
        </div>
      </div>



      <center>
        <!-- Agreement -->
        <input type="checkbox" name="accept-agreement" value="1" required> I agree <a href="#" style="text-decoration: none;">Policy<a>
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
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>