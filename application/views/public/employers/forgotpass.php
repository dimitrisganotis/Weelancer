<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
    <div class="breadcromb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-box-pagin">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li class="active-breadcromb"><a href="">Forgot Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcromb Area End -->

<!-- Reset Passsword Area Start -->
<section class="jobguru-login-area section_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-title">
                        <h3>Forgot Password</h3>
                    </div>
                    <?php echo form_open('employers/forgotpass', 'id="form"') ?>
                        <div class="single-login-field">
                            <input name="email" type="email" placeholder="Email Addresss" required>
                        </div>
                        
                        <div class="single-login-field mt-4">
                            <button id="form-btn" type="submit">&nbsp;Reset Password&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Area End -->