
<?php
require_once '../vendor/autoload.php';
require_once APPROOT . '/helpers/sessionHelper.php';
//SessionHandler::createAdminSession();
//session_start();
//session_destroy();
//$g_client = new Google_Client();
//$g_client->setClientId("882413254155-dqrcsii5mp2f40vc0v4hhj0gkacp9n1q.apps.googleusercontent.com");
//$g_client->setClientSecret("xNA8IIyIJpOmlZ3ZgRvKX8qx");
//$g_client->setRedirectUri("http://essay-lite.io/en/student/dashboard");
//$g_client->setScopes("email");
//$auth_url = $g_client->createAuthUrl();
//$code = isset($_GET['code']) ? $_GET['code'] : NULL;
//
////Step 4: Get access token
//if (isset($code)) {
//
//    try {
//
//        $token = $g_client->fetchAccessTokenWithAuthCode($code);
//        $g_client->setAccessToken($token);
//    } catch (Exception $e) {
//        echo $e->getMessage();
//    }
//
//
//
//
//    try {
//        $pay_load = $g_client->verifyIdToken();
//    } catch (Exception $e) {
//        echo $e->getMessage();
//    }
//} else {
//    $pay_load = null;
//}
//
//if (isset($pay_load)) {
//
//
//
//    var_dump($pay_load['email']);
//}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from seantheme.com/studio/page_register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Jun 2020 05:08:42 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Studio | Register</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link href="<?php echo URLROOT.'/backend/';?>assets/css/app.min.css" rel="stylesheet" />

</head>
<body>

<div id="app" class="app app-full-height app-without-header">

    <div class="register">

        <div class="register-content">
            <form action="<?php echo URLROOT.'/'.$_SESSION["lang"].'/auth/login';?>" method="POST" name="login_form">
                <h1 class="text-center">Sign In</h1>

                <div class="form-group">
                    <label>Email Address <span class="text-danger">*</span></label>
                    <input name="email" type="text" class="form-control form-control-lg fs-15px" required placeholder="username@address.com" value="" />
                </div>
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span></label>
                    <input name="pass" type="password" class="form-control form-control-lg fs-15px" value="" minlength="6" required />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-lg fs-15px fw-500 btn-block">Sign Up</button>
                </div>

            </form>
            <div class="text-muted text-center">
                <a class="btn btn-primary btn-lg fs-15px fw-500 btn-block" href="<?php echo URLROOT.'/'.$_SESSION['lang'].'/auth/google'?>">Google Sign In</a>
            </div>
        </div>

    </div>


    <a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>

</div>


<script src="<?php echo URLROOT.'/backend/';?>assets/js/app.min.js" type="d4d06c1928e59f8d7c6803c1-text/javascript"></script>

<script type="d4d06c1928e59f8d7c6803c1-text/javascript">
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-53034621-1', 'auto');
	  ga('send', 'pageview');

	</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170165335-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-170165335-1');
</script>

<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="d4d06c1928e59f8d7c6803c1-|49" defer=""></script></body>

<!-- Mirrored from seantheme.com/studio/page_register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Jun 2020 05:08:42 GMT -->
</html>


r