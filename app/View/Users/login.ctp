<!DOCTYPE html>
<body class="error-body no-top lazy"  data-original="../app/webroot/img/loginbg.png"  style="background-image: url('/app/webroot/img/loginbg.png'); width: 100%;height: 100%;"> 
    <div class="container">
        <div class="row login-container animated fadeInUp">  
            <div class="col-md-7 col-md-offset-2 tiles white no-padding">
                <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10"> 
                    <h2 class="normal">Sign in to Aiwa Backend App</h2>
                    <p>Use credentials to sign in.<br></p>
                    <p class="p-b-20">Or ask Aiwa management for your credentials...</p>
                    <?php
                    echo $this->Form->create('User', array("url" => array("controller" => "users", "action" => "login", "class" => "animated fadeIn")));
                    ?>

                    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                        <div class="col-md-6 col-sm-6 ">
                            <?php echo $this->Form->input("name", array("div" => false, "label" => false, "type" => "text", "placeholder" => "Username", "class" => "form-control")); ?>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <?php echo $this->Form->input("password", array("div" => false, "label" => false, "type" => "password", "placeholder" => "Password", "class" => "form-control")); ?>
                        </div>
                    </div>
                  
                    <div class="text-center clearfix">
                        <h style = 'color: red;'><?php echo $fialdMassage; ?></h>  
                    </div>
                    <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                        <div class="control-group  col-md-10">
                            <div class="checkbox checkbox check-success"> <a href="#">Trouble login in?</a>&nbsp;&nbsp;

                                <?php echo $this->Form->input('rememberMe', array("id" => "checkbox1", 'checked' => true, 'type' => 'checkbox', 'label' => "Keep me reminded ")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                        <div class="control-group  col-md-12">
                            <?php
                            echo $this->Form->submit(
                                    'Sign in', array('class' => 'btn btn-lg btn-primary btn-block', 'title' => 'Sign in'));
                            ?>
                        </div>
                    </div>


                </div>   
            </div>
        </div>
</body>
