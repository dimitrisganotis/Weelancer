<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
   <div class="breadcromb-bottom">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="breadcromb-box-pagin">
                  <ul>
                     <li><a href="/">home</a></li>
                     <li class="active-breadcromb"><a href="">Contact us</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Breadcromb Area End -->
   
   
<!-- Contact Page Start -->
<section class="jobguru-contact-page-area section_70">
   <div class="container">
      <div class="row">
         <div class="col-md-5">
            <div class="contact-left">
               <h3>Contact information</h3>
               <div class="contact-details">
                  <p><i class="fa fa-map-marker"></i> University of Thessaly, 411 10, Larissa, Greece</p>
                  <div class="single-contact-btn">
                     <h4>Email Us</h4>
                     <a href="mailto:info@weelancer.com" class="jobguru-btn-2">info@weelancer.com</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-7">
            <div class="contact-right">
               <h3>Feel free to contact us!</h3>
               <?php echo form_open('contact', 'id="form"') ?>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="single-contact-field">
                           <input type="text" placeholder="Your Name" name="username" value="<?php echo set_value('username'); ?>" required>
                           <?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="single-contact-field">
                           <input type="email" placeholder="Email Address" name="email" value="<?php echo set_value('email'); ?>" required>
                           <?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="single-contact-field">
                           <input type="text" placeholder="Subject" name="subject" value="<?php echo set_value('subject'); ?>" required>
                           <?php echo form_error('subject', '<small class="text-danger mx-1">', '</small>'); ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="single-contact-field">
                           <textarea placeholder="Write here your message" name="message"><?php echo set_value('message'); ?></textarea>
                           <?php echo form_error('message', '<small class="text-danger mx-1">', '</small>'); ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="single-contact-field">
                           <button id="form-btn" type="submit">&nbsp;<i class="fa fa-paper-plane"></i>&nbsp;Send Message&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <br>
            <?php if($this->session->flashdata('status')) { ?><strong><?php echo $this->session->flashdata('status'); ?></strong><?php } ?>
         </div>
      </div>
   </div>
</section>
<!-- Contact Page End -->