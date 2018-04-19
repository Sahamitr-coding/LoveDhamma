<?php
  require('connect.php');
  session_start();

  if(isset($_SESSION['user_data'])){
    $sql_stmt = "SELECT * FROM user";
    $user_data = ($conn->query($sql_stmt))->fetchAll(); 
  }else{
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>ชุมชน คนชอบปฏิบัติธรรม</title>
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
    <link href="css/CSSPageManageUser.css" rel="stylesheet" type="text/css" >
    <link href="https://fonts.googleapis.com/css?family=Maitree|Trirong" rel="stylesheet">
</head>
<body class="Backg-body">

  <main role="main">
   <!-- แก้ไข -->
<header class="header_Bg">
			<div class="navbar-header width">
        <img class="img left" src="img/Logo1.png" alt="Logo1">

			</div>
				
		</header>

     <nav id="mainnav">
      <div class="width">
          <ul>
            <li><a class="dropbtn2" href="admin.php">Home</a></li>
            <li><a class="dropbtn" href="manage_user.php">Manage User</a></li>
    
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
        <div class="container font-Tri" style="margin-top: 5rem">
            
            <!-- User ทั่วไป รอการapprove -->
            <div class="alert alert-warning" role="alert">

                <?php
                  foreach ($user_data as $item) {
                    if(!$item['admin_confirm']){
                      $id = $item['id'];
                      $str = "<div><a class=\"aManage\" href=\"Approve.php?id=".$id."\">".$item['name']." ".$item['surname']."</a></div>";

                      echo $str;
                    }
                  }
                ?>
            </div>
            <p class="mb-0"><br>
                
            <!-- Member User -->
            <div class="alert alert-warning " role="alert">
                <h1 class="text1">Member user</h1>
                 <?php
                  foreach ($user_data as $item) {
                    if($item['admin_confirm']){
                      $str = "<div><a class=\"aManage\" href=\"#\">".$item['name']." ".$item['surname']."</a></div>";
                      echo $str;
                    }
                  }
                ?>
            </div>
            
        </div>
      
        <!-- footer -->
      <footer id="footer" class="text-center">
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม</span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>
    </footer>
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script>

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
            current.closest("li").remove();

            str = data.split("<li>");
            for(var i = 1; i < str.length - 1; i++){
              str[i] = '<li>'+str[i];
              $(".get-data").append(str[i]);
            }
            
            if(str[str.length - 1] > 1){
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