
$(function(){
  $("body").on('click', '.load_more', function(){
    var lastid = $(this).attr('data-id');
    var current = $(this);
    
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


$('#answer1').on('click', function(){
  $('#question-description').text('');
  $('#answer1').val('');
});

$('#answer2').on('click', function(){
  $('#question-description').text('');
  $('#answer2').val('');
});

$('#answer3').on('click', function(){
  $('#question-description').text('');
  $('#answer3').val('');
});

$('#username-sign-in').on('click', function(e){
  e.preventDefault();
  $('#sign-in-description').text('');
  $('#username-sign-in').val('');
});

$('#password-sign-in').on('click', function(e){
  e.preventDefault();
  $('#sign-in-description').text('');
  $('#password-sign-in').val('');
});

$('#CaptchaEnter').on('click', function(e){
  e.preventDefault();
  $('#CaptchaEnter').val('');
  $('#captcha-description').text('');
});

$('#forget_password').on('click', function(e){
  e.preventDefault();
  var username = $('#username-sign-in').val();
  var password = $('#password-sign-in').val();
  var description = "* Please enter username and password correctly.";
  if(username != ''){
    $.ajax({
      url: 'login_check.php',
      data: {username:username, password:password, data_sending_type:"forget_pwd"},
      type: 'POST',
      success: function(value){
        console.log(value);
        if(value == 'invalid_password' || value == 'pass'){
          window.location.href = "Question.php?username=" + username;
        }else{
          $('#sign-in-description').text(description);
          document.getElementById('sign-in-description').style.color = "red";
          ChangeCaptcha();
        }
      }
    });
  }
});

$('#sign_in_button_click').on('click', function(e){

  e.preventDefault();
  var username = $('#username-sign-in').val();
  var password = $('#password-sign-in').val();
  var description = "* Please enter username and password correctly.";
  

  var pattern = /^[a-z A-Z 0-9 \- \_ ก-ฮ ๐-๙ ฯะัาำิีึืุูเแโใไๅๆ็่้๊๋์]+$/;
  var password_pattern = /^[\#\$\%\^\&\*\(\)\+\=\[\]\'\;\,.\/\{\}\|\:\<\>\?\~\@]+$/;
  if(username == '' || password == ''){
    $('#sign-in-description').text(description);
    document.getElementById('sign-in-description').style.color = "red";

    ChangeCaptcha();

  }else if(!pattern.test(username) || password_pattern.test(password)){
    $('#sign-in-description').text(description);
    document.getElementById('sign-in-description').style.color = "red";

    ChangeCaptcha();

  }else{
    $.ajax({
      url: 'login_check.php',
      data: {username:username, password:password, data_sending_type:"sign_in"},
      type: 'POST',
      success: function(value){
        if(value == 'false'){

          $('#sign-in-description').text(description);
          document.getElementById('sign-in-description').style.color = "red";

          ChangeCaptcha();

        }else if(value == 'invalid_password'){
          $('#sign-in-description').text(description);
          document.getElementById('sign-in-description').style.color = "red";

          ChangeCaptcha();

        }else if(value == 'pass'){
          window.location.href = "index.php";
        }else if(value == 'pass_admin'){
          window.location.href = "admin.php";
        }
      }
    });
  }
});
