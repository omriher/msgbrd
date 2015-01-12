<?php

require '/src/facebook.php';
require 'dbConnect.php';

$facebook = new Facebook(array(
  'appId'  => '',
  'secret' => '',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <script src="http://www.parsecdn.com/js/parse-1.2.9.min.js"></script>
  <script language="JavaScript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
  <script>
  /*
      function TestMsg()
      {
        alert("Text: " + $("#mesg").val());
        alert("Text: <?php echo $user_profile['name'] ?>");
      }
*/
      $(document).ready(function(){ 
                 $("#Post").click(function(){
                     var user = <?php echo $user ?>;
                     var msg = $("#mesg").val();
                     $("#mesg").val('');
                    $.ajax({
                         url : "AddMessage.php", 
                         type : "POST",
                         data :  { user: user, mesg: msg },
                         success : function(n){
                            //more code here                         } 
                          }
                        });
                    alert("Thank you for your post!");

                    refreshTable();
                   });

                 refreshTable();
               });


      function refreshTable(){
        $('#MessagesTable').load('ShowMessages.php');
      }
  </script>
</head>
  <body>
    <font face="Tahoma">
    <h2>All Messages</h2>
    <div id="MessagesTable"></div>
    <hr>
    <?php if ($user) { ?>
    <div class="sndMsg">
      hello, <?php echo $user_profile['name'] ?><br>
      Post a message : <input type=text name="mesg" id="mesg" width=80> 
      <input type="button" value="Post Message" id="Post">
    </div>
    <?php } else { ?>
      You must be logged in through Facebook to Post a message<br>
      <fb:login-button></fb:login-button>
    <?php } ?>
    <div id="fb-root"></div>

    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });

        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </font>
  </body>
</html>
