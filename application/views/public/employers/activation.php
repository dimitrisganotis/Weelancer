<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
    <div class="breadcromb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-box-pagin">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li class="active-breadcromb"><a href="">Acount Activation</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcromb Area End -->

<!-- Alert Area Start -->
<section class="jobguru-login-area section_70">
    <div class="container">
        <?php if($this->session->flashdata('success_active')): ?>
            <div class="alert alert-success text-center">
                <strong>Success!</strong> <?php echo $this->session->flashdata('success_active'); ?>
            </div><br>
        <?php elseif($this->session->flashdata('error_active')): ?>
            <div class="alert alert-danger text-center">
                <strong>Warning!</strong> <?php echo $this->session->flashdata('error_active'); ?>
            </div><br>
        <?php endif; ?>

        <!--<div class="text-center mb-4">
            Click <a href="/" class="font-weight-bold">here</a> to resend!
        </div>-->

        <div class="dont_have">
            <a href="/" class="jobguru-btn">Return to home</a>
        </div>
    </div>
</section>
<!-- Alert Area End -->