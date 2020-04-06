<div hidden id="mapview"></div>

<!-- Banner Area Start -->
<section class="jobguru-banner-area">
   <div class="banner-slider owl-carousel">
      <div class="banner-single-slider slider-item-3">
         <div class="slider-offset"></div>
      </div>

      <div class="banner-single-slider slider-item-1">
         <div class="slider-offset"></div>
      </div>
      <div class="banner-single-slider slider-item-2">
         <div class="slider-offset"></div>
      </div>
   </div>
   <div class="banner-text">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="banner-search">
                  <h2>Find Your Future Job.</h2>
                  <h4>We have <b><?php echo $total_jobs; ?></b> job offers for you! </h4>
                  
                  <form method="GET" accept-charset="utf-8" action="<?php echo site_url('jobs/jobslist'); ?>" id="form">
                     <div class="banner-form-box">
                        <div class="banner-form-input">
                           <input type="text" name="search" placeholder="Search Job Title">
                        </div>

                        <div class="banner-form-input">
                           <input autocomplete="off" name="address" type="text" id="searchInput" placeholder="Enter your Address, City or State" required>
                        </div>
                        
                        <div class="banner-form-input">
                           <button type="submit"><span id="search_span">Search Jobs</span> &nbsp;<i class="fa fa-search"></i></button>
                        </div>
                     </div>
               
                     <div class="hiddeninputs">
                        <input type="hidden" name="" id="location" value=""><br>
                        <input type="hidden" name="" id="route" value=""><br>
                        <input type="hidden" name="" id="street_number" value=""><br>
                        <input type="hidden" name="" id="postal_code" value=""><br>
                        <input type="hidden" name="" id="locality" value=""><br>
                        <input type="hidden" name="lat" id="lat1" value=""><br>
                        <input type="hidden" name="lng" id="lng1" value="">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Banner Area End -->
       
<!-- Categories Area Start -->
<section class="jobguru-categories-area section_70">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="site-heading">
               <h2>top Trending <span>Categories</span></h2>
               <p>A better career is out there. We'll help you find it. We're your first step to becoming everything you want to be.</p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Financial+services'); ?>" class="single-category-holder account_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-briefcase"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Financial services</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/account_cat.jpg" alt="category" />
            </a>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Design%2C+arts+and+crafts'); ?>" class="single-category-holder design_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-pencil-square-o"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Design, arts & crafts</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/design_art.jpg" alt="category" />
            </a>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Food+services'); ?>" class="single-category-holder restaurant_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-cutlery"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Food services</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/restaurent.jpg" alt="category" />
            </a>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Computing+and+ICT'); ?>" class="single-category-holder tech_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-code"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Computing & ICT</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/programing_cat.jpg" alt="category" />
            </a>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Science%2C+mathematics+and+statistics'); ?>" class="single-category-holder data_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-bar-chart"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Mathematics & statistics</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/data_cat.png" alt="category" />
            </a>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Languages'); ?>" class="single-category-holder writing_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-pencil"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Languages</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/writing_cat.jpg" alt="category" />
            </a>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Education+and+training'); ?>" class="single-category-holder edu_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-graduation-cap"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Education & training</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/edu_cat.jpg" alt="category" />
            </a>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="<?php echo site_url('jobs/jobslist?category=Print+and+publishing%2C+marketing+and+advertising'); ?>" class="single-category-holder sale_cat">
               <div class="category-holder-icon">
                  <i class="fa fa-bullhorn"></i>
               </div>
               <div class="category-holder-text">
                  <h3>Marketing & advertising</h3>
               </div>
               <img src="<?php echo base_url(); ?>assets/img/sale_cat.png" alt="category" />
            </a>
         </div>
      </div>
   </div>
</section>
<!-- Categories Area End -->
   
   
<!-- Inner Hire Area Start -->
<section class="jobguru-inner-hire-area section_100">
   <div class="hire_circle"></div>
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="inner-hire-left">
               <h3>Hire an employee</h3>
               <p>You can sign up as a company, post your job advertisement and select candidates from those who applied. What are you waiting for?</p>
               <a href="/employers/signup" class="jobguru-btn-3">sign up as company</a>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Inner Hire Area End -->
   

   
<!-- How Works Area Start -->
<section class="how-works-area section_70">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="site-heading">
               <h2>how it <span>works</span></h2>
               <p>It's easy. Simply post a job you need completed and receive competitive bids from freelancers within minutes.</p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="how-works-box box-1">
               <img src="<?php echo base_url(); ?>assets/img/arrow-right-top.png" alt="works" />
               <div class="works-box-icon">
                  <i class="fa fa-user"></i>
               </div>
               <div class="works-box-text">
                  <p>sign up</p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="how-works-box box-2">
               <img src="<?php echo base_url(); ?>assets/img/arrow-right-bottom.png" alt="works" />
               <div class="works-box-icon">
                  <i class="fa fa-gavel"></i>
               </div>
               <div class="works-box-text">
                  <p>post job</p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="how-works-box box-3">
               <div class="works-box-icon">
                  <i class="fa fa-thumbs-up"></i>
               </div>
               <div class="works-box-text">
                  <p>choose expert</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- How Works Area End -->
