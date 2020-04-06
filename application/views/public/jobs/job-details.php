<!-- Single Candidate Start -->
<section class="single-candidate-page section_70">
   <div class="container">
      <div class="row">
         <div class="col-md-9 col-lg-6">
            <div class="single-candidate-box">
               <div class="single-candidate-img">
                  <img src="<?php echo base_url($image); ?>" alt="single candidate" />
               </div>
               <div class="single-candidate-box-right">
                  <h4><?php echo $job; ?></h4>
                  <p><a href="<?php echo site_url('jobs/company/'.$company_id); ?>" style="color: #a8a8a8;"><?php echo $company; ?></a></p>
                  <div class="job-details-meta">
                     <p><i class="fa fa-eye"></i> Total Views: <?php echo $views; ?></p>
                     <p><i class="fa fa-file-text"></i> Applications: <?php echo $total_applications; ?></p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3 col-lg-6">
            <div class="single-candidate-action">
               <?php if(!$application) { ?>
                  <a href="<?php echo site_url('jobs/do_application/'.$id); ?>" class="candidate-contact"><i class="fa fa-paper-plane-o"></i> Apply Now</a>
               <?php } else { ?>
                  <a href="<?php echo site_url('jobs/undo_application/'.$id); ?>" style="background: #eee; border: #eee; color: #333;" class="candidate-contact"><i class="fa fa-paper-plane-o"></i> Cancel Application</a>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Single Candidate End -->
   
   
<!-- Single Candidate Bottom Start -->
<section class="single-candidate-bottom-area section_70">
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-lg-9">
            <div class="single-candidate-bottom-left">
               <div class="single-candidate-widget">
                  <h3>job Description</h3>
                  <p><?php echo $description; ?></p>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-lg-3">
            <div class="single-candidate-bottom-right">
               <div class="single-candidate-widget-2">
                  <h3>Job overview</h3>
                  <ul class="job-overview">
                     <li>
                        <h4><i class="fa fa-map-marker"></i> Location</h4>
                        <p><?php echo $address; ?>
                     <li>
                        <h4><i class="fa fa-tag"></i> Job Category</h4>
                        <p><?php echo $category; ?></p>
                     </li>
                     <li>
                        <h4><i class="fa fa-thumb-tack"></i> Job Type</h4>
                        <p><?php echo $type; ?></p>
                     </li>
                     <?php if(!empty($salary)) { ?>
                        <li>
                           <h4><i class="fa fa-briefcase"></i> Offerd Salary</h4>
                           <p><?php echo $salary; ?>&euro; Per Month</p>
                        </li>
                     <?php } ?>
                     <li>
                        <h4><i class="fa fa-clock-o"></i> Date Posted</h4>
                        <p><?php echo $created_at; ?></p>
                     </li>
                  </ul>
               </div>
               <div class="single-candidate-widget-2">
                  <h3>Quick Contact</h3>
                  <?php echo form_open('jobs/details/'.$id, 'id="form"') ?>
                     <?php if($this->session->flashdata('status')) { ?><p class="minima"><strong><?php echo $this->session->flashdata('status'); ?></strong></p><?php } ?>
                     <p>
                        <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="Your Name" required>
                        <?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
                     </p>
                     <p>
                        <input type="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Your Email Address" required>
                        <?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
                     </p>
                     <p>
                        <textarea placeholder="Write here your message" name="message"><?php echo set_value('message'); ?></textarea>
                        <?php echo form_error('message', '<small class="text-danger mx-1">', '</small>'); ?>
                     </p>
                     <p>
                        <button id="form-btn" type="submit">&nbsp;Send Message&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                     </p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Single Candidate Bottom End -->

<script>
   window.setTimeout(function () {
      $(".minima").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
      });
   }, 3000);
</script>
