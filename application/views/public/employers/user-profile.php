			<div hidden id="mapview"></div>
			<div class="col-lg-9 col-md-12">
				<div class="dashboard-right">
					<div class="candidate-profile">
						<div class="candidate-single-profile-info">
							<div class="single-resume-feild resume-avatar">
								<div class="resume-image">
									<img class="file-upload-image" src="<?php echo base_url($image); ?>" alt="resume avatar">
								</div>
							</div>
						</div>

						<div class="candidate-single-profile-info">
							<div class="resume-box">
								<h3>Personal Details</h3>
								<div class="single-resume-feild feild-flex-2">
									<div class="single-input">
										<label for="username">Full Name</label><br>
										<p class="info_label"><?php echo $username; ?></p>
									</div>

									<div class="single-input">
										<label for="profession">Professional title</label><br>
										<p class="info_label">
											<?php if(empty($profession)):	echo '-'; else:	echo $profession; endif;?>
										</p>
									</div>
								</div>

								<div class="single-resume-feild feild-flex-2">
									<div class="single-input">
										<label for="native_lang">Native Language</label><br>
										<p class="info_label">
											<?php if(empty($native_lang)):	echo '-'; else:	echo $native_lang; endif;?>
										</p>
									</div>

									<div class="single-input">
										<label for="birthdate">Birth Date</label><br>
										<p class="info_label">
											<?php if($birthdate == '0000-00-00'): echo '-'; else: echo $birthdate; endif;?>
										</p>
									</div>
								</div>

								<div class="single-resume-feild ">
									<div class="single-input">
										<label for="description">User Description</label><br>
										<p class="info_textarea">
											<?php if(empty($description)): echo '-'; else: echo $description; endif; ?>
										</p>
									</div>
								</div>
							</div>

							<?php if(!empty($cv)): ?>
									<div class="single-resume-feild ">
										<div class="single-input cv_link">
											<a href="<?php echo base_url($cv); ?>" class="jobguru-btn" target="blanc"><i class="fa fa-arrow-circle-o-down"></i> Download CV</a>
										</div>
									</div>
								<?php endif; ?>

							<div class="resume-box">
								<h3>Contact Information</h3>
								<div class="single-resume-feild feild-flex-2">
									<div class="single-input">
										<label for="phone">Phone</label><br>
										<?php if(empty($phone)): ?>
											<p class="info_label"><?php echo '-'; ?></p>
										<?php else: ?>
											<p class="info_label"><a href="tel:<?php echo $phone ?>"><?php echo $phone ?></a></p>
										<?php endif; ?>
									</div>

									<div class="single-input">
										<label for="email">Email</label><br>
										<p class="info_label"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
									</div>
								</div>

								<div class="single-resume-feild">
									<div class="single-input">
										<label for="searchInput">Address</label><br>
										<p class="info_label">
											<?php if(empty($address)): echo '-'; else: echo $address; endif; ?>
										</p>
									</div>
								</div>
							</div>

							<div class="resume-box" <?php if($state != "Pending"): ?>style="margin-bottom: 0"<?php endif; ?>>
								<h3>social links</h3>
								<div class="single-resume-feild feild-flex-2">
									<div class="single-input">
										<label for="facebook"><i class="fa fa-facebook facebook"></i> Facebook</label>
										<br>
										<?php if(empty($facebook)): ?>
											<p class="info_label"><?php echo '-'; ?></p>
										<?php else: ?>
											<p class="info_label"><a target="_blank" href="<?php echo $facebook; ?>" style="text-decoration: underline;">[Facebook Profile]</a></p>
										<?php endif; ?>
									</div>

									<div class="single-input">
										<label for="linkedin"><i class="fa fa-linkedin linkedin"></i> LinkedIn</label>
										<br>
										<?php if(empty($linkedin)): ?>
											<p class="info_label"><?php echo '-'; ?></p>
										<?php else: ?>
											<p class="info_label"><a target="_blank" href="<?php echo $linkedin; ?>" style="text-decoration: underline;">[LinkedIn Profile]</a></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
							
							<?php if($state == "Pending"): ?>
								<div class="employer_actions">
									<a href="<?php echo site_url('employers/candidate_approval/'.$application_id); ?>" class="jobguru-btn-2" style="color: white!important; margin-right: 5px;" onclick="return confirm_approval();">Approve</a>
									<a href="<?php echo site_url('employers/candidate_rejection/'.$application_id); ?>" class="jobguru-btn-danger" style="color: white!important; margin-left: 5px;" onclick="return confirm_rejection();">Decline</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Candidate Dashboard Area End -->

<script>
		function confirm_approval() {
      return confirm("Are you sure about the approval?");
    }

    function confirm_rejection() {
      return confirm("Are you sure about the rejection?");
    }
</script>
