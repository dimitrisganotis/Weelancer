<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
    <div class="breadcromb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-box-pagin">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li class="active-breadcromb"><a href="">Choose new Password</a></li>
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
                        <h3>Choose new Password</h3>
                    </div>

                    <?php echo form_open('employers/forgotpass/'.$url, 'id="form"') ?>
                        <div class="single-login-field">
                            <input name="password" type="password" pattern=".{4,}" title="Four or more characters" placeholder="Enter new Password" required>
                        </div>

                        <div class="single-login-field">
                            <input name="password_confirm" type="password" pattern=".{4,}" title="Four or more characters" placeholder="Confirm new Password" required>
                        </div>
                        
                        <div class="single-login-field mt-4">
                            <button id="form-btn" type="submit">&nbsp;Change password&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Reset Passsword End -->