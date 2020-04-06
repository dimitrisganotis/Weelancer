    <!-- Footer Area Start -->
<footer class="jobguru-footer-area">
    <div class="footer-top section_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-footer-widget">
                        <div class="footer-logo">
                            <a href="index-2.html">
                                <img src="<?php echo base_url(); ?>assets/img/weelancer_logo_w.png" alt="Weelancer" />
                            </a>
                        </div>
                        <p class="mb-2">Weelancer is an online job finding platform that helps employers find the right people for their company.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-footer-widget">
                        <h3>Main Links</h3>
                        <ul>
                            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-angle-double-right "></i> Home</a></li>
                            <li><a href="<?php echo site_url('about'); ?>"><i class="fa fa-angle-double-right "></i> About Weelancer</a></li>
                            <li><a href="<?php echo site_url('contact'); ?>"><i class="fa fa-angle-double-right "></i> Contact with an expert</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-footer-widget footer-contact">
                        <h3>Contact Info</h3>
                        <p><i class="fa fa-map-marker"></i> University of Thessaly, 411 10, Larissa, Greece </p>
                        <p><i class="fa fa-envelope-o"></i> info@weelancer.com</p>
                        <ul class="footer-social">
                            <li><a href="#" class="fb mr-1"><i  class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="twitter mr-1"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-left">
                        <p>Weelancer.com &copy; <?php echo date("Y"); ?>. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area End -->



<script src="<?php echo base_url(); ?>assets/js/geolocation.js"></script>
<!--Jquery js-->
<script src="<?php echo base_url(); ?>assets/js/jquery-3.0.0.min.js"></script>
<!--Popper js-->
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<!--Bootstrap js-->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!--Bootstrap Datepicker js-->
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<!--Perfect Scrollbar js-->
<script src="<?php echo base_url(); ?>assets/js/jquery-perfect-scrollbar.min.js"></script>
<!--Owl-Carousel js-->
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
<!--SlickNav js-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/js/jquery.slicknav.min.js"></script>-->
<!--Magnific js-->
<script src="<?php echo base_url(); ?>assets/js/jquery.magnific-popup.min.js"></script>
<!--Select2 js-->
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<!--jquery-ui js-->
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<!--Main js-->
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<!--Spinner js-->
<script src="<?php echo base_url(); ?>assets/js/spinner.js"></script>
<script src="<?php echo base_url(); ?>assets/js/uploadform.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function(){
        $(".banner-single-slider").css({"height": $(window).height()});
    });

    $(window).resize(function(){
        $('.banner-single-slider').css({'height': $(window).height()});
    });

    if ($(document).height() == $(window).height()) {
        $('html').attr('style', 'height: 100%!important; background-color: #f0f3fa;');
        $('header').attr('style', 'background-color: #fff; border-bottom: 2px solid #f0f3fa');
        $('footer').attr('style', 'position: fixed!important; bottom: 0px; left: 0px; right: 0px;');
    }
</script>

<script>
    $( function() {
      $("#birthdate").datepicker( {
        dateFormat: "yy-mm-dd",
        showAnim: "slideDown",
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0"
      });
    });
</script>

<script>
    $("#switcherStatus").on("change", function () {
        if ($(this).is(":checked")) {
            document.getElementById('switcherStatus').value = '1';
            document.getElementById('messageStatus').innerHTML = 'Active Employer';
        } else {
            document.getElementById('switcherStatus').value = '0';
            document.getElementById('messageStatus').innerHTML = 'Inactive Employer';
        }
    });
</script>

<script>
    $(".toggle-sidebar").on("click",function()
    {
        $(".side-nav").removeClass("side-nav-container-closed");
        $(".side-nav").addClass("side-nav-container");
        $(".side-nav-screen-hold").fadeIn("fast");
    });
    $(".side-nav-screen-hold").on("click", function()
    {
        $(".side-nav").removeClass("side-nav-container");
        $(".side-nav").addClass("side-nav-container-closed");
        $(".side-nav-screen-hold").fadeOut("fast");
    });
</script>

</body>
</html>

