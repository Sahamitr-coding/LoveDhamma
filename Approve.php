<?php
  require('connect.php');
  session_start();
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql_stmt = "SELECT * FROM user WHERE id=$id";
    $user_data = ($conn->query($sql_stmt))->fetch();
    if(!$user_data){
      header("Location: index.php");
    }
  }else{
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="css/main.css" rel="stylesheet">
  <link href="css/bootstrap-grid.css" rel="stylesheet">
  <link href="css/bootstrap-reboot.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Pattaya" rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link href="css/carousel.css" rel="stylesheet" type="text/css" >
  <link href="https://fonts.googleapis.com/css?family=Maitree|Trirong" rel="stylesheet">
  <link href="css/Approve-button.css" rel="stylesheet">
</head>
<body class="Backg-body">

  <main role="main">
   <!-- แก้ไข -->
<header class="header_Bg">
      <div class="navbar-header width">
        <img class="img left" src="img/Logo1.png" alt="Logo1">
        <spen class="right">
            <?php 
                if(isset($_SESSION['user_data'])){
                  $html_username_tag = "<div><a id=\"open_username\" class=\"btn-link\" href=\"profile.php\">สวัสดีคุณ ".$_SESSION['user_data']['username']."</a></div>";
                  $html_sign_out = "<div><a id=\"sign_out\" class=\"btn-link\" href=\"index.php?sign_out\">Sign out</a></div>";

                  echo $html_username_tag.$html_sign_out;

                }else{
                  $html_sign_in = "<div><a id=\"open_the_modal\" class=\"btn-link\" href=\"#openModal_sign_in\">Sign in</a></div>";
                  $html_register = "<div><a id=\"go_to_register_page\" class=\"btn-link\" href=\"register.php\">Register</a></div>";

                  echo $html_sign_in.$html_register;
                }
              ?>
        </spen>
      </div>
        
    </header>

     <nav id="mainnav">
      <div class="width">
          <ul>
              <li class="dropdown">
                  <?php 
                    if(isset($_SESSION['user_data'])){
                      if($_SESSION['user_data']['permission']){
                        $str = "admin.php";
                      }else{
                        $str = "index.php";
                      }
                    }
                  ?>
                  <button class="dropbtn2"><a href="<?php echo $str;?>">Home</a></button>
              </li>
              <li><a class="dropbtn2" href="manage_user.php">Manage User</a></li>
              
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
    <!-- end แก้ไข -->

      <div class="register_container" style="margin-bottom: 3rem;">
        <h3 style="text-align: center; margin-top: 2rem;">Profile</h3><hr>
        <form id="register_form" class="font-Tri" method="post" enctype="multipart/form-data">

          <form role="form"> 
                <?php
                    $row = $user_data;
                    if(!isset($row)){
                      header("Location: index.php");
                    }
                    $question = [
                        "What is the name of your pet?",
                        "What is your favorite color?",
                        "What is your best friend’s name?",
                        "What is your favorite song?",
                        "What is your favorite singer?",
                        "What is your favorite movie?",
                        "What is your favorite super hero?",
                        "What is your dream career?",
                        "What is your hometown?",
                        "What is your high school’s name?",
                        "What is your favorite brand?",
                        "What is your favorite sport?",
                        "What is your favorite hobby?",
                        "What is your favorite season?",
                        "What is your favorite subject?"
                    ];
                    $LengthSSN = strlen($row['national_id'])-2;
                    $ShowSSN = str_repeat("x", $LengthSSN);
                    $LengthPassword = strlen($row['password']);
                    $showPassword = str_repeat("x", $LengthPassword);
                    $LengthA1 = strlen($row['answer_1']);
                    $LengthA2 = strlen($row['answer_2']);
                    $LengthA3 = strlen($row['answer_3']);
                    echo "<table>";
                    echo "<tr><td>ชื่อ-นามสกุล : </td><td>".$row['name']."  ".$row['surname']."</td></tr>";
                    //echo "<tr><td>เลขประจำตัวประชาชน : </td><td>".substr_replace($row['national_id'], $ShowSSN,2)."</td></tr>";
                    echo "<tr><td>เลขประจำตัวประชาชน : </td><td>".$row['national_id']."</td></tr>";
                    echo '<tr><td>Username : </td><td>'.$row['username'].'</td></tr>';
                    echo "<tr><td>Password : </td><td>".$showPassword."</td></tr>";
                    echo '<tr><td>Birth date : </td><td>'.date("d-m-Y", strtotime($row['birthday'])).'</td></tr>';
                    echo "<tr><td>Question 1 : </td><td>".$question[$row['question_1_id']-1]."</td></tr>";
                    echo "<tr><td>Answer 1 : </td><td>".str_repeat("x", $LengthA1)."</td></tr>";
                    echo "<tr><td>Question 2 : </td><td>".$question[$row['question_2_id']-1]."</td></tr>";
                    echo "<tr><td>Answer 2 : </td><td>".str_repeat("x", $LengthA2)."</td></tr>";
                    echo "<tr><td>Question 3 : </td><td>".$question[$row['question_3_id']-1]."</tr>";
                    echo "<tr><td>Answer 3 : </td><td>".str_repeat("x", $LengthA3)."</td></tr>";
                   
                    echo "</table><br>";
                    echo '<div class="text-center">';
                  if(!empty($row['file_content'])){
                   echo '<img src="data:image/jpeg;base64,'.base64_encode($row['file_content']).'" width="500" height="900" />';
                  }else{
                    echo '<img src="uploads/'.$row['file_name'].'" width="500" height="900" />';
                  }     
                    echo '</div>';
                ?>
        </form>
          </form>
    </div>

  <div class="text-center" style="margin-bottom: 3rem;">
    <button id="approve" class="button">Approve</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="disapprove" class="button button3">Disapprove</button>
  </div>


    <footer id="footer" class="text-center fixed">
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม</span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>
    </footer>
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script>
      var id = "<?php echo $id; ?>";
      $('#approve').on('click', function(e){
        
        $.ajax({
          url: 'approve_process.php',
          data: {is_approve:1,id:id},
          type: 'POST',
          success: function(value){
            window.location.href = "manage_user.php";
          }
        });
      });
      $('#disapprove').on('click', function(e){
        $.ajax({
          url: 'approve_process.php',
          data: {is_approve:-1,id:id},
          type: 'POST',
          success: function(value){
            window.location.href = "manage_user.php";
          }
        });
      });
    </script>
  </main>
</body>
</html>