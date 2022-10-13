<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
// foreach($this->Session->read("monitor_name") as $key => $value)
// {
// 	$MonitorName = $value['monitors']['name'];
// 	// debug($MonitorName);
// }

// exit;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <?php echo $this->Html->charset(); ?>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array('pace-theme-flash', 'datepicker', 'ios7-switch', 'select2', 'bootstrap-clockpicker.min', 'bootstrap.min', 'bootstrap-theme.min', 'font-awesome', 'animate.min', 'jquery.scrollbar', 'style', 'responsive', 'custom-icon-set','aiwamsg'));
        echo $this->Html->script(array('jquery-1.8.3.min.js', 'jquery-ui-1.10.1.custom.min.js', 'bootstrap.min.js', 'breakpoints.js', 'jquery.unveil.min.js', 'jqueryblockui.js', 'jquery.lazyload.min.js', 'jquery.scrollbar.min.js', 'core.js', 'demo.js', 'jquery.sidr.min.js', 'jquery.slimscroll.min.js', 'pace.min.js', 'jquery.animateNumbers.js', 'raphael-min.js', 'd3.v2.js', 'jquery-sparkline.js', 'skycons.js', 'owl.carousel.min.js', 'jquery.flot.js', 'MetroJs.min.js', 'bootstrap-datepicker.js', 'bootstrap-timepicker.min.js', 'select2.min.js', 'bootstrap-clockpicker.min.js', 'bootstrap-datepicker.js', 'bootstrap-timepicker.min.js', 'ios7-switch.js', 'select2.min.js', 'bootstrap-clockpicker.min.js', "canvasjs.min.js","aiwamsg.js" ));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        <style>
            .success-message{
                background: no-repeat 5px 5px;
                border-radius: 5px;
                border-style: solid;
                border-width: 2px;
                box-shadow: 0 5px 5px -5px #555;
                margin-bottom: .5em;
                min-height: 24px;
                padding: 5px 10px 5px 35px;
                background-color: #DEFADE;
                background-image: url("<?php echo Configure::read('img_url') . '/app/webroot/img/success.png'; ?>");
                border-color: #267726;
                color: #267726;
                opacity: 0.5;
                filter: alpha(opacity=50);

            }

            .error-message{
                background: no-repeat 5px 5px;
                border-radius: 5px;
                border-style: solid;
                border-width: 2px;
                box-shadow: 0 5px 5px -5px #555;
                margin-bottom: .5em;
                min-height: 22px;
                padding: 5px 10px 5px 35px;
                background-color: #FFCCCC;
                background-image: url("<?php echo Configure::read('img_url') . '/app/webroot/img/error.png'; ?>");
                border-color: #8F0000;
                color: #8F0000;
                opacity: 0.5;
                filter: alpha(opacity=50);
            }
        </style>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#flashMessage').animate({opacity: 1.0}, 5000).fadeOut();
                $("#source").select2();
                $("#source0").select2();
                $("#source1").select2();
                $("#source2").select2();
                $("#source3").select2();
                $("#source4").select2();
                $("#source5").select2();
                $("#source6").select2();
                $("#source7").select2();
                $("#source8").select2();
                $("#source9").select2();
                $("#multi").select2();
                $('.input-append.date').datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd",
                    todayHighlight: true
                });
                $('.clockpicker ').clockpicker({
                    autoclose: true

                });

                //$('#flashMessage').animate({opacity: 1.0}, 4000).fadeOut();
                // $(".live-tile,.flip-list").liveTile();
            });
        </script>
    </head>
    <body>
        <?php if (!in_array($this->request->params["action"], array("login" , 'terms_en' , 'terms_ar'))) { ?>
            <div class="header navbar navbar-inverse ">
                <!-- BEGIN TOP NAVIGATION BAR -->
                <div class="navbar-inner">
                    <div class="header-seperation">
                        <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
                            <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" >
                                    <div class="iconset top-menu-toggle-white"></div>
                                </a> </li>
                        </ul>
                        <!-- -->
                        <a href="<?php echo $this->Html->url(array("controller" => "users", "action" => "welcome")); ?>">
							<img src="<?php echo Configure::read('img_url') . '/app/webroot/img/logo0_w.png'; ?>" class="logo" alt=""  data-src="<?php echo Configure::read('img_url') . '/app/webroot/img/logo0_w.png'; ?>" data-src-retina ="<?php echo Configure::read('img_url') . '/app/webroot/img/logo0_w.png'; ?>" width="60" height="30" style="margin-bottom: 25px;"/>
						</a>

                        <ul class="nav pull-right notifcation-center">
                            <li class="dropdown" id="header_task_bar">
								<a href="#" class="dropdown-toggle active" data-toggle="">
                                    <div class="iconset top-home"></div>
                                </a>
							</li>
                        </ul>
                    </div>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <div class="header-quick-nav" >
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="pull-left">
                            <ul class="nav quick-section">
                                <li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle" >
                                        <div class="iconset top-menu-toggle-dark"></div>
                                    </a> </li>
                            </ul>
                            <ul class="nav quick-section">
                                <li class="quicklinks"><a href="#" class="" >
                                        <div class="iconset top-reload"></div>
                                    </a> </li>
                                <li class="quicklinks"> <span class="h-seperate"></span></li>
                                <li class="quicklinks"> <a href="#" class="" >
                                        <div class="iconset top-tiles"></div>
                                    </a> </li>

                            </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                        <!-- BEGIN CHAT TOGGLER -->
                        <div class="pull-right">
                            <div class="chat-toggler">
								<a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'account'));?>" id="my-task-list">
                                    <div class="user-details">
                                        <div class="username">
											<span class="bold"><?php echo $this->Session->read("User.User.fname");?></span>
										</div>
                                    </div>
                                </a>
                            </div>
                            <ul class="nav quick-section ">
                                <li class="quicklinks">
									<a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                                        <div class="iconset top-settings-dark "></div>
                                    </a>
                                    <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                                        <li><a href="#"> My Account</a></li>
                                        <li class="divider"></li>
                                        <li>
											<a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')); ?>"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a>
										</li>
                                    </ul>
                                </li>
                                <li class="quicklinks"></li>
                            </ul>
                        </div>
                        <!-- END CHAT TOGGLER -->
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END TOP NAVIGATION BAR -->
            </div>

            <div class="page-container row-fluid">
                <div class="page-sidebar" id="main-menu">
                    <!-- BEGIN MINI-PROFILE -->
                    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
                        <!-- BEGIN SIDEBAR MENU -->
                        <ul>
                            <li class="start">
								<a href="index.html">
									<i class="icon-custom-extra"></i><span class="title" style="font-size: 17px;">Service Providers</span><span class="selected"></span><span class="arrow open"></span>
								</a>
                                <ul class="sub-menu">
                                    <li class="active" id="Accounts Need Action">
										<a href="<?php echo $this->Html->url(array("controller" => "ServiceProviders", "action" => "showall_needaction")); ?>">Accounts Need Action</a>
									</li>
									<li class="active" >
										<a id="All Accounts" href="<?php echo $this->Html->url(array("controller" => "ServiceProviders", "action" => "showall")); ?>">All Accounts</a>
									</li>
                                    <li class="active" id="Pending Accounts">
										<a href="<?php echo $this->Html->url(array("controller" => "ServiceProviders", "action" => "showall_pending")); ?>">Pending Accounts</a>
									</li>
                                </ul>
                            </li>

                            <li class="start">
								<a href="index.html"><i class="icon-custom-chart"></i><span class="title" style="font-size: 17px;">Analysis</span> <span class="selected"></span> <span class="arrow open"></span></a>
                                    <ul class="sub-menu">
                                        <li class="active">
											<a href="<?php echo $this->Html->url(array("controller" => "dashboards", "action" => "totals")); ?>"> Totals </a>
										</li>
                                    </ul>
                            </li>
                            <li class="start">
								<a href="index.html">
									<i class="icon-custom-downloads"></i> <span class="title" style="font-size: 17px;">Admin</span> <span class="selected"></span><span class="arrow open"></span>
								</a>
                                <ul class="sub-menu">
									<li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "AdminProfile", "action" => "showall")); ?>"> Admin Profile </a>
									</li>
                                    <li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "MainCategories", "action" => "showall")); ?>"> Main Categories </a>
									</li>
                                    <li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "Categories", "action" => "showall")); ?>"> Jobs </a>
									</li>
                                    <li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "SubServices", "action" => "showall")); ?>"> Sub Services </a>
									</li>
									<li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "Discounts", "action" => "showall")); ?>"> Discount </a>
									</li>
									<li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "Terms", "action" => "showall")); ?>"> Terms & Conditions </a>
									</li>
									<li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "Advertising", "action" => "showall")); ?>"> Advertising Images </a>
									</li>
                                    <li class="active">
										<a href="<?php echo $this->Html->url(array("controller" => "ComplainTitle", "action" => "showall")); ?>"> complain titles </a>
									</li>
                                </ul>
                            </li>
                            <li class="start">
								<a href="index.html">
									<i class="icon-custom-new"></i><span class="title" style="font-size: 17px;">Users</span> <span class="selected"></span> <span class="arrow open"></span>
								</a>
                                <ul class="sub-menu">
                                    <li class="active">
										<a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'showall')); ?>"> Manage Users </a>
									</li>
                                </ul>
                            </li>
                            <li class="start ">
								<a href="#" >
									<i class="fa fa-key"></i><span class="title" style="font-size: 15px; font-weight: bold;">My Account</span> <span class="selected"></span> <span class="arrow open"></span>
								</a>
                                <ul class="sub-menu">
                                    <li>
										<a href="#">Profile</a>
									</li>
                                    <li>
										<a href="<?php echo $this->Html->url(array('controller' => 'AdminProfile', 'action' => 'logout'));?>"> Log Out</a>
									</li>
                                </ul>
                            </li>
                            <li class="start ">
								<a href="<?php echo $this->Html->url(array('controller' => 'Aiwacsmessages', 'action' => 'index'));?>" >
									<i class="fa fa-inbox"></i><span class="title" style="font-size: 15px; font-weight: bold;">Chat</span> <span class="selected"></span> <span class="arrow open"></span>
								</a>
                            </li>
                            
                        </ul>
                        <div class="clearfix"></div>
                        <!-- END SIDEBAR MENU -->
                    </div>
                </div>

                <div class="page-content">
                    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                    <div id="portlet-config" class="modal hide">
                        <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button"></button>
                            <h3></h3>
                        </div>
                        <div class="modal-body"> </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="content">
                        <?php echo $this->Session->flash('flash'); ?>
                        <?php echo $this->fetch('content'); ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        <?php } ?>
        <?php echo $this->element('sql_dump'); ?>

		<!-- <script>
			var MonName  = document.getElementById("All Accounts").innerHTML;
			console.log(typeof(MonName))
			console.log(MonName)
			var Mon_name = "<?php echo $MonitorName; ?>";
			console.log(typeof(Mon_name))
			console.log(Mon_name)
			if(Array.isArray(Mon_name))
			{
				Mon_name.forEach(function (item, index) {
					console.log(item, index);
				});
			}
			if(MonName == Mon_name)
			{
				document.getElementById("All Accounts").style.display = "none";
			}
		</script> -->
    </body>
</html>
