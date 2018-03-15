<?php
  require('connect.php');
   
  if(isset($_GET['id'])){
     $c_id = $_GET['id'];
  }else{
    $c_id = 1;
  }
  $sql = "SELECT * FROM news WHERE id = $c_id";
  $result = ($conn->query($sql))->fetch();

  //get previous
  $sql = "SELECT * FROM news WHERE id = (SELECT max(id) FROM news WHERE id < $c_id)";
  $previous = ($conn->query($sql))->fetch();

  //get next
  $sql = "SELECT * FROM news WHERE id = (SELECT min(id) FROM news WHERE id > $c_id)";
  $next = ($conn->query($sql))->fetch();
?>

<!DOCTYPE html>
<html>
<head>
  <title>ธ.นำธรรมดี</title>
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
              <li class="selected-item" ><a href="news_form.php">News and Announcements</a></li>
              <li><a href="#">Knowledge sources</a></li>
              <li><a href="#">Events</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Profile</a></li>
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
    <!-- end แก้ไข -->
    
    <div class="container font-Tri" style="margin-top: 5rem; color: black;" >
    	<h3 class="text-center " style="font-weight: bold;">
        <?php
          echo $result["title"];
        ?>
      </h3><br>
    	<?php
           echo $result["detail"];
      ?>
		<p class="text-right">
    <br><br>
    <?php
          $timestamp = strtotime($result["date"]);
          echo "วันที่ " .date('d', $timestamp). " เดือน ". get_month_name(date('m', $timestamp)). " พ.ศ. ".
          (int)(date('Y', $timestamp)+543); 
    ?>  
    </p>
		<br><br>
		<div class="container row font-Tri" style="margin-top: 5rem">
        <div class="previos-news text-left col">
          <?php
            if(isset($previous['title'])){
              echo "<a id=\"prev\" href=\"news_form.php?id=". $previous["id"]. "\">"."Previous". "</a>";
            }
          ?>
        </div>
        <div class="next-news text-right col">
          <?php
            if(isset($next['title'])){
              echo "<a id=\"next\" href=\"news_form.php?id=". $next["id"]. "\">". "Next". "</a>";
            }
          ?>
        </div>
      </div>
    </div>

    <footer id="footer" class="text-center">
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน ธ.นำธรรมดี </span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>       
    </footer>
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script>
      /* When the user clicks on the button, 
      toggle between hiding and showing the dropdown content */
      function myFunction() {
          document.getElementById("myDropdown").classList.toggle("show");
      }

      // Close the dropdown if the user clicks outside of it
      window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {

          var dropdowns = document.getElementsByClassName("dropdown-content");
          var i;
          for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
            }
          }
        }
      }
    </script>
  </main>
</body>
</html>