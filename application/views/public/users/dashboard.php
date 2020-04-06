<div class="col-lg-9 col-md-12">
	<div class="dashboard-right">
		<div class="welcome-dashboard" style="background-color: #fff; border-radius: 5px">
            <h3 style="padding-bottom: 5px">Welcome <span><?php echo $user['username']; ?>!</span></h3>
            <small style="padding: 0 20px 20px 20px; display: block; font-size: 90%; font-style: italic">Member Since <b><?php echo date("F Y", strtotime($user['created_at'])); ?></b></small>
		</div>
		<div class="progressbox">
			<h3 class="profile_strength">Profile Level: <b><?php echo $user['account_level']; ?></b></h3>
			<p class="profile_percentage">You have complete <b><?php echo $user['account_completion']; ?>%</b> of your profile.</p>
			<div class="progress">
				<div class="progress-bar progress-bar-animated animated slideInLeft" style="width: <?php echo $user['account_completion']; ?>%; background-color: #25AD60; animation-iteration-count: 1; border-right: 3px solid #333"></div>
			</div>
		</div>

		<div class="d-flex justify-content-between block_stats">
			<div class="job_stats">
                <h4>Approved</h4>
				<div id="circle1"></div>
			</div>

            <div class="job_stats">
                <h4>Pending</h4>
				<div id="circle3"></div>
			</div>

			<div class="job_stats">
                <h4>Rejected</h4>
				<div id="circle2"></div>
			</div>
		</div>
        <div class="row justify-content-between align-items-center" style="margin: 30px 0 0 0; color: #333; background-color: #fff; border-radius: 5px; padding: 20px">
            <div class="col-6 text-center">
                <a href="#export" class="jobguru-btn-2" onclick="generatepdf()">Export Data</a>
            </div>

            <div class="col-6 text-center">
                <a href="#modal" class="jobguru-btn-danger" data-toggle="modal" data-target="#modal">Delete Account</a>
            </div>
        </div>
        <br>

        <!--<table id="test"></table>
        <button onclick="generatepdf()">Download PDF</button>-->
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

                <?php echo form_open('users/deleteuser', 'class="form-inline"'); ?>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/progressbar.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jspdf.min.js"></script>

<script>
	function generatepdf() {
        /*var doc = new jsPDF('p','px','a4', true);

        var doc = new jsPDF({
            orientantion: 'portrait',
            unit: 'px',
            format: [4, 2]
        });
        
        var header = [1,2,3,4];

        doc.table(10, 10, $('#test').get(0), header, {
            left:10,
            top:10,
            bottom: 10,
            width: 170,
            autoSize:false,
            printHeaders: true
        });*/

        // Documentation: http://raw.githack.com/MrRio/jsPDF/master/docs/

        // Default export is a4 paper, portrait, using milimeters for units
        var doc = new jsPDF({
            orientation: 'l',
            unit: 'pt', //pt, mm, cm, m, in, px
            format: 'credit-card'
        })

        doc.text('Weelancer!', 10, 60)
        doc.text('Under Construction...', 10, 100)
        doc.save('weelancer-data.pdf')

	}
</script>

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

    bar.animate(<?php if($user['total'] !== 0): echo $user['approves']/$user['total']; else: echo '0.0'; endif; ?>);  // Number from 0.0 to 1.0

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

    bar1.animate(<?php if($user['total'] !== 0): echo $user['rejections']/$user['total']; else: echo '0.0'; endif; ?>);  // Number from 0.0 to 1.0

    var bar2 = new ProgressBar.Circle(circle3, {
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
    bar2.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar2.text.style.fontSize = '2rem';

    bar2.animate(<?php if($user['total'] !== 0): echo $user['pending']/$user['total']; else: echo '0.0'; endif; ?>);  // Number from 0.0 to 1.0
</script>
