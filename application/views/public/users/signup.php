<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
   <div class="breadcromb-bottom">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="breadcromb-box-pagin">
                  <ul>
                     <li><a href="/">home</a></li>
                     <li class="active-breadcromb"><a href="">Sign up</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Breadcromb Area End -->
   
   
<!-- Login Area Start -->
<section class="jobguru-login-area section_70">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="login-box">
               <div class="login-title">
                  <h3>Sign up as candidate</h3>
               </div>

               <?php echo form_open('users/signup', 'id="form"') ?>
                  <div class="single-login-field">
                     <input name="username" type="text" placeholder="Full Name" value="<?php echo set_value('username'); ?>" required>
                     <?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
                  </div>

                  <div class="single-login-field">
                     <input name="email" type="email" placeholder="Email Addresss" value="<?php echo set_value('email'); ?>" required>
                     <?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
                  </div>

                  <div class="single-login-field">
                     <input name="password" type="password" pattern=".{4,}" title="Four or more characters" placeholder="Choose Password" required>
                     <?php echo form_error('password', '<small class="text-danger mx-1">', '</small>'); ?>
                  </div>

                  <div class="single-login-field">
                     <input name="password_confirm" type="password" pattern=".{4,}" title="Four or more characters" placeholder="Confirm Password" required>
                     <?php echo form_error('password_confirm', '<small class="text-danger mx-1">', '</small>'); ?>
                  </div>

                  <div class="single-login-field mt-4">
                     <button id="form-btn" type="submit">&nbsp;Sign up&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                  </div>
               </form>

               <div class="dont_have">
                  <a href="/users/login">Already have an account?</a>
               </div>
               
               <div class="dont_have">
                  <a href="/employers/signup" class="jobguru-btn">Sign up your company</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Login Area End -->

