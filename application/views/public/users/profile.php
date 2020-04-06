<div hidden id="mapview"></div>
<div class="col-lg-9 col-md-12">
	<div class="dashboard-right">
		<div class="candidate-profile">
			<?php if ($this->session->flashdata('success')): ?>
				<!-- Success message -->
				<div class="alert alert-success text-center mb-4" role="alert">
					<strong><?php echo $this->session->flashdata('success'); ?></strong>
				</div>
			<?php elseif ($this->session->flashdata('error')): ?>
				<!-- Error message -->
				<div class="alert alert-warning text-center mb-4" role="alert">
					<strong><?php echo $this->session->flashdata('error'); ?></strong>
				</div>
			<?php endif; ?>

			<?php echo form_open_multipart('users/profile', 'id="form"') ?>
			<div class="candidate-single-profile-info">
				<div class="single-resume-feild resume-avatar">
					<div class="resume-image">
						<img class="file-upload-image" src="<?php echo base_url($image); ?>" alt="resume avatar">
					</div>

					<div class="file-upload">
						<div class="image-upload-wrap">
							<input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*"
								   name="image"/>
							<div class="drag-text">
								<h3>Drag and drop a file or select your image</h3>
							</div>
						</div>

						<div class="file-upload-content">
							<div class="image-title-wrap">
								<button type="button" onclick="removeUpload()" class="remove-image">Remove <span
										class="image-title">Uploaded Image</span></button>
							</div>
						</div>

						<?php echo form_error('image', '<small class="text-danger mx-1">', '</small>'); ?>
					</div>
				</div>
			</div>

			<div class="candidate-single-profile-info">
				<div class="resume-box">
					<h3>My Profile</h3>
					<div class="single-resume-feild feild-flex-2">
						<div class="single-input">
							<label for="username">Full Name*</label>
							<input type="text" placeholder="Enter your name and surname"
								   value="<?php echo $username; ?>" id="username" name="username" required>
							<?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>

						<div class="single-input">
							<label for="profession">Professional title</label>
							<input type="text" placeholder="Enter your profession" value="<?php echo $profession; ?>"
								   id="profession" name="profession">
							<?php echo form_error('profession', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>

					<div class="single-resume-feild feild-flex-2">
						<div class="single-input">
							<label for="native_lang">Native Language</label>
							<select id="native_lang" name="native_lang">
								<option <?php if ($native_lang == NULL) echo 'selected'; ?> value="">- Select Language
									-
								</option>
								<option <?php if ($native_lang == 'Greek') echo 'selected'; ?> value="Greek">Greek
								</option>
								<option <?php if ($native_lang == 'English') echo 'selected'; ?> value="English">
									English
								</option>
								<option <?php if ($native_lang == 'Chinese') echo 'selected'; ?> value="Chinese">
									Chinese
								</option>
								<option <?php if ($native_lang == 'Spanish') echo 'selected'; ?> value="Spanish">
									Spanish
								</option>
								<option <?php if ($native_lang == 'Arabic') echo 'selected'; ?> value="Arabic">Arabic
								</option>
								<option <?php if ($native_lang == 'Portuguese') echo 'selected'; ?> value="Portuguese">
									Portuguese
								</option>
								<option <?php if ($native_lang == 'Indonesian/Malaysian') echo 'selected'; ?>
									value="Indonesian/Malaysian">Indonesian / Malaysian
								</option>
								<option <?php if ($native_lang == 'Japanese') echo 'selected'; ?> value="Japanese">
									Japanese
								</option>
								<option <?php if ($native_lang == 'Russian') echo 'selected'; ?> value="Russian">
									Russian
								</option>
								<option <?php if ($native_lang == 'French') echo 'selected'; ?> value="French">French
								</option>
								<option <?php if ($native_lang == 'German') echo 'selected'; ?> value="German">German
								</option>
								<option <?php if ($native_lang == 'Other') echo 'selected'; ?> value="Other">Other
								</option>
							</select>
							<?php echo form_error('native_lang', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>

						<div class="single-input">
							<label for="birthdate">Birth Date</label>
							<input type="text" placeholder="Enter your birth date"
								   value="<?php if ($birthdate != '0000-00-00') echo $birthdate; ?>" id="birthdate"
								   name="birthdate" autocomplete="off" readonly="true">
							<?php echo form_error('birthdate', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>

					<div class="single-resume-feild ">
						<div class="single-input">
							<label for="description">Introduce Yourself</label>
							<textarea id="description" class="tinymce"
									  name="description"><?php echo $description; ?></textarea>
							<?php echo form_error('description', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>

					<div class="single-resume-feild ">
						<div class="single-input">
							<label for="description">Upload Your CV (.PDF)</label>
							<br>
							<?php if (!empty($cv)):
								?>
								<i><label>Current File: </label> <a target="_blank"
																	href="<?php echo base_url($cv); ?>"><?php echo strtr($username, [' ' => '']); ?>
										_CV.pdf</a></i>
							<?php
							endif;
							?>
							<input type='file' accept="application/pdf" name="cv"/>
							<?php echo form_error('cv', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>
				</div>

				<div class="resume-box">
					<h3>Contact Information</h3>
					<div class="single-resume-feild feild-flex-2">
						<div class="single-input">
							<label for="phone">Phone</label>
							<input type="text" placeholder="Enter your phone" value="<?php echo $phone; ?>" id="phone"
								   name="phone">
							<?php echo form_error('phone', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>

						<div class="single-input">
							<label for="email">Email*</label>
							<input type="text" placeholder="Enter your email" value="<?php echo $email; ?>" id="email"
								   name="email" required>
							<?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>

					<div class="single-resume-feild">
						<div class="single-input">
							<label for="searchInput">Address</label>
							<input autocomplete="off" type="text" placeholder="Enter your Address"
								   value="<?php echo $address; ?>" id="searchInput" name="address">
							<?php echo form_error('address', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>

						<div class="hiddeninputs">
							<input type="hidden" name="" id="location" value=""><br>
							<input type="hidden" name="" id="route" value=""><br>
							<input type="hidden" name="" id="street_number" value=""><br>
							<input type="hidden" name="" id="postal_code" value=""><br>
							<input type="hidden" name="" id="locality" value=""><br>
							<input type="hidden" name="lat" id="lat1" value=""><br>
							<input type="hidden" name="lng" id="lng1" value="">
						</div>
					</div>
				</div>

				<div class="resume-box">
					<h3>Social Links</h3>
					<div class="single-resume-feild feild-flex-2">
						<div class="single-input">
							<label for="facebook"><i class="fa fa-facebook facebook"></i>Facebook</label>
							<input type="text" value="<?php echo $facebook; ?>" placeholder="Facebook URL" id="facebook"
								   name="facebook">
							<?php echo form_error('facebook', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>

						<div class="single-input">
							<label for="linkedin"><i class="fa fa-linkedin linkedin"></i>LinkedIn</label>
							<input type="text" value="<?php echo $linkedin; ?>" placeholder="Linkedin URL" id="linkedin"
								   name="linkedin">
							<?php echo form_error('linkedin', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>
				</div>

				<div class="resume-box">
					<h3>Change User Password</h3>
					<div class="single-resume-feild feild-flex-2">
						<div class="single-input">
							<label for="password">Password</label>
							<input type="password" placeholder="Enter your new password" id="password" name="password">
							<?php echo form_error('password', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>

						<div class="single-input">
							<label for="password_confirm">Confirm Password</label>
							<input type="password" placeholder="Enter your new password again" id="password_confirm"
								   name="password_confirm">
							<?php echo form_error('password_confirm', '<small class="text-danger mx-1">', '</small>'); ?>
						</div>
					</div>
				</div>

				<div class="submit-resume">
					<button type="submit" id="form-btn">&nbsp;Update&nbsp;<i class='fa fa-spinner fa-spin'
																			 style="display:none;"></i></button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</section>
<!-- Candidate Dashboard Area End -->
<script>
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);
</script>
