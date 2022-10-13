<div class="page-title">	
    <i class="icon-custom-home"></i>
    <h5> <span class="semi-bold">Home</span></h5>	
</div>
<style>
    .ads_sponsors div img{
        width:200px;
        height:150px;
    }
    #box {
        text-align: center; margin: 15px; padding: 15px; 
    }
</style>
<div class="row" >
    <div class="col-md-12">
        <div class="grid simple ">
            <div id="container">
                <div class="row 2col">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div class="panel-group" id="accordion" data-toggle="collapse">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                Service Providers DashBoard
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" >
                                        <div class="panel-body">
                                                <div class="col-md-4 col-sm-6 spacing-bottom-sm spacing-bottom" onclick="window.location = '<?php echo $this->Html->url(array("controller" => "ServiceProviders", "action" => "showall")); ?>';">
                                                    <div class="tiles blue added-margin">
                                                        <div class="tiles-body">
                                                            <div class="tiles-title"> Active Service Providers </div>
                                                            <div class="heading"> <span class="animate-number" data-value="<?php echo $Active_Service_Provider; ?>" data-animation-duration="1500"></span>  </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="col-md-4 col-sm-6 spacing-bottom-sm spacing-bottom" onclick="window.location = '<?php echo $this->Html->url(array("controller" => "ServiceProviders", "action" => "showall_needaction")); ?>';">
                                                <div class="tiles yellow added-margin">
                                                    <div class="tiles-body">
                                                        <div class="tiles-title">  Pending Service Providers </div>
                                                        <div class="heading"> <span class="animate-number" data-value="<?php echo $Pending_Service_Provider; ?>" data-animation-duration="1500"></span>  </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6 spacing-bottom-sm spacing-bottom">
                                                <div class="tiles red added-margin">
                                                    <div class="tiles-body">
                                                        <div class="tiles-title">  Rejected Service Providers </div>
                                                        <div class="heading"> <span class="animate-number" data-value="<?php echo $Rejected_Service_Provider; ?>" data-animation-duration="1500"></span>  </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6 col-sm-6 spacing-bottom-sm spacing-bottom">
                                                    <div class="tiles green added-margin">
                                                        <div class="tiles-body">
                                                            <div class="tiles-title"> Today Reservations </div>
                                                            <div class="heading"> <span class="animate-number" data-value="0" data-animation-duration="1500">0</span> EGP </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 spacing-bottom">
                                                    <div class="tiles red added-margin">
                                                        <div class="tiles-body">
                                                            <div class="tiles-title"> Today Income </div>
                                                            <div class="heading"><span class="animate-number" data-value="0" data-animation-duration="1500">0</span> EGP </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                Normal Users DashBoard
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="col-md-6 col-sm-6 spacing-bottom-sm spacing-bottom">
                                                <div class="tiles green added-margin">
                                                    <div class="tiles-body">
                                                        <div class="tiles-title"> Active Users </div>
                                                        <div class="heading"> <span class="animate-number" data-value="<?php echo $Active_User; ?>" data-animation-duration="1500"></span> </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 spacing-bottom">
                                                <div class="tiles yellow added-margin">
                                                    <div class="tiles-body">
                                                        <div class="tiles-title"> Accounts Not Activated </div>
                                                        <div class="heading"><span class="animate-number" data-value="<?php echo $Pending_User; ?>" data-animation-duration="1500"></span>  </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.ads_sponsors').slick({
        autoplay: true,
        autoplaySpeed: 1000,
        slidesToShow: 5,
        slidesToScroll: 2,
        arrows: false,
    });
    document.addEventListener('DOMContentLoaded', function () {
        if (!Notification) {
            alert('Desktop notifications not available in your browser. Try Chromium.');
            return;
        }

        if (Notification.permission !== "granted")
            Notification.requestPermission();
    });

    function notifyMe() {
        if (Notification.permission !== "granted")
            Notification.requestPermission();
        else {
            var notification = new Notification('Notification title', {
                icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                body: "Hey there! You've been notified!",
            });

            notification.onclick = function () {
                window.open("http://stackoverflow.com/a/13328397/1269037");
            };

        }

    }
</script>