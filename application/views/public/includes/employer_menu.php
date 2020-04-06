<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
         <div class="breadcromb-top section_100">
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <div class="breadcromb-box">
                        <h3>
                            <?php if($title == "Dashboard"){
                                echo "Employer Dashboard";
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
               <div class="col-md-12 col-lg-3 dashboard-left-border">
                  <div class="dashboard-left">
                     <ul class="dashboard-menu">
                        <li <?php if($title == "Dashboard") { echo 'class="active"'; } ?>><a href="/employers/dashboard"><i class="fa fa-tachometer"></i>Dashboard</a></li>
                        <li <?php if($title == "Company Profile") { echo 'class="active"'; } ?>><a href="/employers/profile"><i class="fa fa-users"></i>Company Profile</a></li>
                        <li <?php if($title == "Post Job") { echo 'class="active"'; } ?>><a href="/employers/postjob"><i class="fa fa-envelope-open"></i>Post Job</a></li>
                        <li <?php if($title == "Manage Jobs" || $title == "Manage Candidates" || $title == "Candidate Profile" || $title == "Edit Job") { echo 'class="active"'; } ?>><a href="/employers/managejobs"><i class="fa fa-briefcase"></i>manage jobs</a></li>
                        <li <?php if($title == "Manage Employers" || $title == "Add Employer" || $title == "Edit Employer") { echo 'class="active"'; } ?>><a href="/employers/manageemployers"><i class="fa fa-user"></i>manage employers</a></li>
                        <li ><a href="/employers/logout"><i class="fa fa-power-off"></i>LogOut</a></li>
                     </ul>
                  </div>
               </div>