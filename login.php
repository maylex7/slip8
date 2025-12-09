<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keyword" content="">
<title>สถาบันโรคทรวงอก : Slip Online</title>

<style type="text/css">
@font-face {
	font-family: Taviraj ;
	src: url( fonts/Taviraj.ttf ) format("truetype");
}
.Taviraj { font-family: Taviraj; }


@font-face {
	font-family: ChakraPetch ;
	src: url( fonts/ChakraPetch.ttf ) format("truetype");
}
.ChakraPetch { font-family: ChakraPetch; }

</style>


<!-- Favicons -->
<link href="img/favicon.png" rel="icon">
<link href="img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Bootstrap core CSS -->
<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!--external css-->
<link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">

<!-- =======================================================
Template Name: Dashio
Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
Author: TemplateMag.com
License: https://templatemag.com/license/
======================================================= -->
</head>

<body>
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<div id="login-page">
<div class="container">
<form class="form-login" action="active.php" method="post" autocomplete='off' onsubmit="prepareToSend()">
	
<h2 class="form-login-heading"><!--<img src='img/logo.png' width=25%><Br><Br>-->ระบบ Slip Online <br><br>สถาบันโรคทรวงอก</h2>

<div class="login-wrap">

 <input type="text" id="u" name="u_fake" placeholder="Username" autocomplete="off" autofocus class="form-control"/>
<!--<input type="text" class="form-control" placeholder="User ID" autofocus name='USERNAME_ID'>-->
<br>

<input type="text" id="maskedInput"  name="p_fake" placeholder="Password" autocomplete="new-password"  class="form-control"  oncopy="return false;" oncut="return false;" onpaste="return false;" oncontextmenu="return false;" />


<!--<input type="password" class="form-control" placeholder="Password" name='USER_PASSWORD'>-->
<input type="hidden" name="realInput" id="realInput">

<Br>
<button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp; เข้าสู่ระบบ</button>
<?php
$password = MD5('12345678'); 
//echo "$password<br>";
?>
</div>

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Forgot Password ?</h4>
</div>
<div class="modal-body">
<p>Enter your e-mail address below to reset your password.</p>
<input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
</div>
<div class="modal-footer">
<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
<button class="btn btn-theme" type="button">Submit</button>
</div>
</div>
</div>
</div>
<!-- modal -->

</form>

<script>
  const maskedInput = document.getElementById('maskedInput');
  const realInput = document.getElementById('realInput');
  let realValue = '';

  maskedInput.addEventListener('keydown', function(e) {
    if (e.key === "Backspace") {
      realValue = realValue.slice(0, -1);
    } else if (e.key.length === 1 && !e.ctrlKey && !e.metaKey) {
      realValue += e.key;
    } else {
      return;
    }

    setTimeout(() => {
      maskedInput.value = '*'.repeat(realValue.length);
    });
  });

  function prepareToSend() {
    realInput.value = realValue; // ใส่ค่าจริงก่อนส่ง
  }
</script>
</div>
</div>
<!-- js placed at the end of the document so the pages load faster -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<!--BACKSTRETCH-->
<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
<script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
<script>
$.backstretch("img/login-bg.png", {
speed: 500
});
</script>
</body>

</html>
