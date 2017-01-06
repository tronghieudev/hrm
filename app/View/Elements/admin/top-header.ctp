<!-- Logo -->
<a href="<?php echo $this->Html->url(['controller' => 'admins', 'action' => 'index'], true ); ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>Nal</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Nal</b> Solutions</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php echo  $this->Html->image("user2-160x160.jpg", array(
                        "alt" => "Abc",
                        "class" => "user-image"
                     )
                 ) ;?>
                <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <?php echo  $this->Html->image("user2-160x160.jpg", array(
                                "alt" => "Abc",
                                "class" => "img-circle"
                             )
                         ) ;?>
                        <p>
                            Alexander Pierce - Web Developer
                            <small>Member since Nov. 2012</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-6 text-center" >
                                <a  data-toggle="modal" href='#change-password'>Change password</a>
                            </div>
                            <div class="col-xs-6 text-center">
                                <a href="#">Sales</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo $this->Html->url(['controller' => 'auth', 'action' => 'logout', 'admin' => false], true ); ?>" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>