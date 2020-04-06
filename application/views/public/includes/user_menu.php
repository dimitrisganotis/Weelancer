<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
    <div class="breadcromb-top section_100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-box">
                        <h3>
                            <?php if($title == "Dashboard"){
                                echo "Candidate Dashboard";
                            }else{
                                echo $title;
                            } ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcromb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-box-pagin">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li class="active-breadcromb"><a href=""><?php echo $title; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcromb Area End -->


<!-- Candidate Dashboard Area Start -->
<section class="candidate-dashboard-area section_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 dashboard-left-border">
                <div class="dashboard-left">
                    <ul class="dashboard-menu">
                        <li <?php if($title == "Dashboard"){echo "class='active'";} ?>><a href="/users/dashboard"><i class="fa fa-tachometer"></i>Dashboard</a></li>
                        <li <?php if($title == "My Profile"){echo "class='active'";} ?>><a href="/users/profile"><i class="fa fa-users"></i>My Profile</a></li>
                        <li <?php if($title == "Manage Jobs"){echo "class='active'";} ?>><a href="/users/managejobs"><i class="fa fa-briefcase"></i>manage jobs</a></li>
                        <li><a href="/users/logout"><i class="fa fa-power-off"></i>LogOut</a></li>
                    </ul>
                </div>
            </div>