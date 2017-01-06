<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <?php echo  $this->Html->image("user2-160x160.jpg", array(
                 "alt" => "Abc")
             ) ;?>
        </div>
        <div class="pull-left info">
            <p>Alexander Pierce</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->

    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo $this->Html->url(['controller' => 'positions', 'action' => 'index', 'admin' => true], true ); ?>">
                <i class="fa fa-dashboard"></i> <span>Positions</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo $this->Html->url(['controller' => 'positions', 'action' => 'index', 'admin' => true], true ); ?>">
                <i class="fa fa-dashboard"></i> <span>Departments</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo $this->Html->url(['controller' => 'currencies', 'action' => 'index', 'admin' => true], true ); ?>">
                <i class="fa fa-dashboard"></i> <span>Currency</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo $this->Html->url(['controller' => 'staffs', 'action' => 'index', 'admin' => true], true ); ?>">
                <i class="fa fa-dashboard"></i> <span>Staffs</span>
            </a>
        </li>
    </ul>
</section>