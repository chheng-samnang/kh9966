     <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                
              <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">                                                                    
                        <li>
                            <a href="<?php echo base_url('admin/Main');?>"><i class="fa fa-bar-chart-o"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>admin/User"><i class="glyphicon glyphicon-user"></i> User Management</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-desktop"></i> General Management<span class="fa arrow"></span></a>
                             <ul class="nav nav-second-level">
                                
                                 <li>
                                    <a href="<?php echo base_url();?>admin/account_c"><i class="glyphicon glyphicon-flash"></i> Account Setup</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>admin/VAT_c"><i class="glyphicon glyphicon-road"></i> VAT Setup</a>
                                </li>
                            </ul>   
                        </li>                                                                                               
                        <li><!-- Website menu-->
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Website menu Managements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url();?>admin/location_c"><i class="glyphicon glyphicon-send"></i> Location Setup</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>admin/about_us_c"><i class="glyphicon glyphicon-user"></i> About us Setup</a>
                                </li>                               
                                
                                <li>
                                    <a href="<?php echo base_url();?>admin/contact_us_c"><i class="glyphicon glyphicon-earphone"></i> Contact us Setup</a>
                                </li>
                               
                                                               
                            </ul>                            
                        </li><!-- end Website menu-->
                        <li>
                            <a href="<?php echo base_url();?>admin/category_c"><i class="glyphicon glyphicon-list"></i> Category Managements</a>
                        </li>
                                                                                                                                                            
                                                                     
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
   </nav>