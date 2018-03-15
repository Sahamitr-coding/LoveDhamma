<?php
  require('connect.php');
  $sql = "SELECT * FROM news ORDER BY id DESC LIMIT 10";
  $result = $conn->query($sql);
  $get_result = ($conn->query($sql))->fetchAll();
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
              <li class="selected-item"><a href="index.php">Home</a></li>
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
    <!-- end แก้ไข -->
    <section id="main-slider" class="navbar-body no-margin">
    <div id="myCarousel" class=" carousel slide " data-ride="carousel">
        <ol class="carousel-indicators">
          <?php
              $i = 0;
              if($result->rowCount() == 0){
                echo "<li data-target=\"#myCarousel\" data-slide-to=\"0\"></li>";
              }
              while($i < 5 &&  $i < $result->rowCount()){
                if($i == 0)
                  echo "<li data-target=\"#myCarousel\" data-slide-to=\"".$i."\" class=\"active\"></li>";
                else
                  echo "<li data-target=\"#myCarousel\" data-slide-to=\"".$i."\"></li>";
                $i = $i + 1;
              }
          ?>
        </ol>
        <div class="carousel-inner font-Tri">
          <?php
            $num = $result->rowCount() >= 5? 5:$result->rowCount();
            if($num == 0){
              echo 
              "<div class=\"carousel-item active\" >".
                "<img src=\"data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\">".
                "<div class=\"container\">".
                "<div class=\"carousel-caption\">".
                  "<a href=\"#\" >".
                    "<h1>NULL!
                    </h1>
                    </a>
                  </div>
                </div>
              </div>";  
            }
            for ($i = 0; $i < $num; $i++){
              $sql_img = "SELECT name FROM pic WHERE id_news=".$get_result[$i]['id']." AND is_img_slider = 1";
              $img_result = ($conn->query($sql_img)->fetch());
              $active = "";
              if($i == 0){
                $active = "active";
              }
              echo 
              "<div class=\"carousel-item ". $active. " \" >".
                "<img src=\"news-img/". $get_result[$i]['id']."/" .$img_result['name']. "\">".
                "<div class=\"container\">".
                "<div class=\"carousel-caption\">".
                  "<a href=\"news_form.php?id=".$get_result[$i]['id']."\" target=\"_blank\">".
                    "<h1>".$get_result[$i]['title'].
                    "</h1>
                    </a>
                  </div>
                </div>
              </div>";  
            }
          ?>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
           </div></section>
       <!-- End slider -->

       <section id="services" class="text-center">
       <div style="max-width: 90%; margin: 0px auto;" class="alert" role="alert">
        <div class="col-sm-6 alert d-block p-2 backg-news font-color1 border-white">
        <p class="font-color3 font-Tri" > <MARQUEE behavior=alternate direction=left scrollAmount=3 width="4%"><font face=Webdings >4</font></MARQUEE><b>News &amp; Announcement</b><MARQUEE behavior=alternate direction=right scrollAmount=3 width="4%"><font face=Webdings>3</font></MARQUEE> </p>
        <table class="table table-striped table-hover font-Tri">
          <tbody class="get-data" id="list-data">
            <?php
              foreach ($result as $news) {
                $string = $news['title'];
                if(strlen($string) > 140){
                  $stringCut = substr($string, 0, 140);
                  $string = $stringCut.'...';
                }
                 $timestamp = strtotime($news['date']);
                  $catdate = "&nbsp;&nbsp;&nbsp;&nbsp;".date('d', $timestamp)."-".date('m',$timestamp)."-".(int)(date('Y', $timestamp) + 543);
                  $string .= $catdate;
                $string = iconv("UTF-8", "UTF-8//IGNORE", $string);
                echo "<tr><td><a id=\"".$news['id']."\" href=\"news_form.php?id=".$news['id']."\" target=\"_blank\" class=\"font-color4\">". $string."</a></td></tr>";
              }
            ?>
          </tbody>
          </table>
            <div id="load-more" class="load_more text-right font-Tri" data-id=<?php echo end($get_result)['id'];?>> more...</div>         
      </div>
     </div>
    </section>

    <footer id="footer" class="text-center">
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน ธ.นำธรรมดี </span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>
    </footer>
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
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

     function showMore(){

      var s = $('.table tbody#more tr td').length;
      console.log(s);
      var x = (x+10 <= s) ? x+10 : s;
      $('.table tbody#more tr td:lt('+x+')').show(); 
     }

    $(function(){
      $("body").on('click', '.load_more', function(){
        var lastid = $(this).attr('data-id');
        var current = $(this);
        console.log(lastid);
        
        $.post("page.php",{lastId:lastid}, function(data){
            current.closest("tr").remove();
            $(".get-data").append(data);
            str = data.split("<tr>");
            if(str[str.length-1] > 1){
              $('.load_more').attr('data-id', parseInt(str[str.length-1]));
            }else{
              $('.load_more').remove();
            }
        });
      });
    });

    </script>
  </main>
</body>
</html>