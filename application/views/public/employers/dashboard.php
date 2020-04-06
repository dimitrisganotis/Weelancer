         <div class="col-md-12 col-lg-9">
            <div class="dashboard-right">
               <div class="welcome-dashboard" style="background-color: #fff; border-radius: 5px">
                  <h3 style="padding-bottom: 5px">Welcome <span><?php echo $employer['username']; ?> [<?php echo $company['title']; ?>]!</span></h3>
                  <small style="padding: 0 20px 20px 20px; display: block; font-size: 90%; font-style: italic">Member Since <b><?php echo date("F Y", strtotime($employer['created_at'])); ?></b></small>
               </div>

               <div class="d-flex justify-content-between block_stats">
                  <div class="job_stats">
                        <h4 class="mb-2">Total Posted Jobs</h4>

                        <div class="badge badge-pill badge-light border">
                            <i class="fa fa-hashtag" aria-hidden="true"></i> <b><?php echo $company['posted_jobs']; ?></b>
                        </div>
                  </div>

                  <div class="job_stats">
                        <h4 class="mb-2">Total Jobs Views</h4>

                        <div class="badge badge-pill badge-light border">
                            <i class="fa fa-hashtag" aria-hidden="true"></i> <b><?php echo $company['jobs_views']; ?></b>
                        </div>
                  </div>

                  <div class="job_stats">
                        <h4 class="mb-2">Total Employers</h4>

                        <div class="badge badge-pill badge-light border">
                            <i class="fa fa-hashtag" aria-hidden="true"></i> <b><?php echo $company['total_employers']; ?></b>
                        </div>
                  </div>
               </div>

               <div class="d-flex justify-content-between block_stats">
                  <div class="job_stats">
                        <h3>Approved Candidates</h3>
                     <div id="circle1"></div>
                  </div>

                  <div class="job_stats">
                        <h3>Pending Candidates</h3>
                     <div id="circle3"></div>
                  </div>

                  <div class="job_stats">
                        <h3>Rejected Candidates</h3>
                     <div id="circle2"></div>
                  </div>
               </div>

               <div class="row justify-content-between align-items-center" style="margin: 30px 0 0 0; color: #333; background-color: #fff; border-radius: 5px; padding: 20px">
                     <div class="col-6 text-center">
                        <a href="#" class="jobguru-btn-2">Export Data</a>
                     </div>

                     <div class="col-6 text-center">
                        <a href="#modal" class="jobguru-btn-danger" data-toggle="modal" data-target="#modal">Delete Account/Company</a>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Candidate Dashboard Area End -->

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Delete Account</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">Are you sure you want to delete your account?</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                <?php echo form_open('employers/deletecompany', 'class="form-inline"'); ?>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/progressbar.js"></script>
<script>
    var bar = new ProgressBar.Circle(circle1, {
        color: '#333',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 5,
        trailWidth: 5,
        easing: 'easeInOut',
        duration: 1400,
        text: {
            autoStyleContainer: false
        },
        from: {color: '#25AD60', width: 5},
        to: {color: '#25AD60', width: 5},
        // Set default step function for all animate calls
        step: function (state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round(circle.value() * 100) + "%";
            if (value === 0) {
                circle.setText('');
            } else {
                circle.setText(value);
            }

        }
    });
    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';

    bar.animate(<?php if($employer['total'] !== 0): echo $employer['approves']/$employer['total']; else: echo '0.0'; endif; ?>);  // Number from 0.0 to 1.0

    var bar1 = new ProgressBar.Circle(circle2, {
        color: '#333',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 5,
        trailWidth: 5,
        easing: 'easeInOut',
        duration: 1400,
        text: {
            autoStyleContainer: false
        },
        from: {color: '#da2828', width: 5},
        to: {color: '#da2828', width: 5},
        // Set default step function for all animate calls
        step: function (state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round(circle.value() * 100) + "%";
            if (value === 0) {
                circle.setText('');
            } else {
                circle.setText(value);
            }

        }
    });
    bar1.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar1.text.style.fontSize = '2rem';

    bar1.animate(<?php if($employer['total'] !== 0): echo $employer['rejections']/$employer['total']; else: echo '0.0'; endif; ?>);  // Number from 0.0 to 1.0

    var bar1 = new ProgressBar.Circle(circle3, {
        color: '#333',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 5,
        trailWidth: 5,
        easing: 'easeInOut',
        duration: 1400,
        text: {
            autoStyleContainer: false
        },
        from: {color: '#17a2b8', width: 5},
        to: {color: '#17a2b8', width: 5},
        // Set default step function for all animate calls
        step: function (state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round(circle.value() * 100) + "%";
            if (value === 0) {
                circle.setText('');
            } else {
                circle.setText(value);
            }

        }
    });
    bar1.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar1.text.style.fontSize = '2rem';

    bar1.animate(<?php if($employer['total'] !== 0): echo $employer['pending']/$employer['total']; else: echo '0.0'; endif; ?>);  // Number from 0.0 to 1.0
</script>
