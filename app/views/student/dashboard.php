<?php
require_once APPROOT . '/helpers/sessionHelper.php';
require_once APPROOT . '/views/inc/panelHead.php';
?>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="wrapper">
        <?php
        require_once APPROOT . '/views/inc/panelNav.php';
        require_once APPROOT . '/views/inc/panelSideBar.php';
        ?>
        <div id="page-wrapper">
            <div class="container-fluid">
               
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Total Order</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-success"></i>
                                 <span class="counter text-success"><?php echo $data['total_order']; ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Completed Order</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash2"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-purple"></i> 
                                <span class="counter text-purple"><?php echo $data['completed_order']; ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Canceled Order</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> 
                                <span class="counter text-info"><?php echo $data['canceled_order']; ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm6">
                        <div class="white-box" style="height: 200px; margin-top:20px;">
                        <h3 class="box-title"><?php echo $lang['Start A Order']?></h3>
                        <a class="btn btn-success" role="button" href="<?php echo URLROOT . '/' . $_SESSION["lang"] . '/Student/StartOrderRequest';  ?>"><?php echo $lang['Start']?></a>
                        </div> 
                    </div> 
                    <div class="col-md-4 col-sm6">
                        <div class="white-box" style="height: 200px; margin-top:20px;">
                        <h3 class="box-title">Message Center</h3>
                        <a class="btn btn-success" role="button" href="">Message Center</a>
                        </div> 
                    </div> 
                    <div class="col-md-4 col-sm6">
                        <div class="white-box" style="height: 200px; margin-top:20px;">

                        <h3 class="box-title"><?php echo $lang['my Profile']?></h3>
                        <a class="btn btn-success" role="button" href="<?php echo URLROOT.'/'.$_SESSION["lang"].'/User/findProfile';?>"><?php echo $lang['my Profile']?></a>
                        </div> 
                    </div> 
                </div>
               
            </div>
            
            <div class="white-box">
                            <h3 class="box-title"><?php echo $lang['My Request']; ?></h3>
                            <div class="table-responsive">
                                <?php if(isset($data['order_request'][0])) : ?>
                                <table class="table">
                                    <tbody>
                                    <?php  foreach($data['order_request'] as $request): ?>
                                        <tr>
                                            <td><span class="badge badge-info"><?php echo $request['subject']; ?></span></td>
                                            <td><?php echo $lang['Type']. ': '. $request['type']; ?></td>
                                            <td ><span class="badge badge-secondary"><?php echo $lang['Duration']. ': ' .$request['duration']. $lang['Day']; ?></span></td>
                                            <td><?php echo $lang['Service']. ': '. $request['service']; ?></td>
                                            <td><?php echo $lang['Style']. ': '. $request['style']; ?></td>
                                            <td><?php echo $lang['Price']. ' $'. $request['price']; ?></td>

                                            <td>
                                                <button onclick="deleteRequest(<?php echo $request['id']; ?>)" class="btn btn-danger"><?php echo $lang['Delete']; ?></button>
                                            </td>
                                            <td><a href="<?php echo URLROOT . '/User/getMyRequest?myrequest='.$request['id']; ?>"><?php echo $lang['See Details']; ?></a></td>
                        
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div>
                        </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center">
                <?php echo COPYRIGHT; ?>
            </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <?php
    require_once APPROOT . '/views/inc/panelScript.php';

    ?>
</body>

</html>