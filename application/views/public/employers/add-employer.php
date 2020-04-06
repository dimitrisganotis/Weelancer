                <div class="col-md-12 col-lg-9">
                    <div class="dashboard-right">
                        <div class="candidate-profile" style="padding: 20px;">
                            <?php if($this->session->flashdata('success')): ?>
                                <!-- Success message -->
                                <div class="alert alert-success text-center mb-4" role="alert">
                                    <strong><?php echo $this->session->flashdata('success'); ?></strong>
                                </div>
                            <?php elseif($this->session->flashdata('error')): ?>
                                <!-- Error message -->
                                <div class="alert alert-warning text-center mb-4" role="alert">
                                    <strong><?php echo $this->session->flashdata('error'); ?></strong>
                                </div>
                            <?php endif; ?>

                            <div class="candidate-single-profile-info">
                                <?php echo form_open('employers/addemployer', 'id="form"') ?>
                                    <div class="resume-box" style="margin-bottom: 0px">
                                        <h3 style="border-bottom-width: 0px;padding-bottom: 0px;margin-bottom: 30px;margin-top: 0px;">Create Employer</h3>
                                        <div class="single-resume-feild feild-flex-2">
                                            <div class="single-input">
                                                <label for="username">Full Name*</label>
                                                <input name="username" type="text" placeholder="Enter Full Name" id="username" value="<?php echo set_value('username'); ?>" required>
                                                <?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
                                            </div>

                                            <div class="single-input">
                                                <label for="email">Email*</label>
                                                <input name="email" type="email" placeholder="Enter Email" id="email" value="<?php echo set_value('email'); ?>" required>
                                                <?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
                                            </div>
                                        </div>

                                        <div class="single-resume-feild feild-flex-2">
                                            <div class="single-input">
                                                <label for="password">Password*</label>
                                                <input name="password" type="password" placeholder="Enter Password" id="password" required>
                                                <?php echo form_error('password', '<small class="text-danger mx-1">', '</small>'); ?>
                                            </div>

                                            <div class="single-input">
                                                <label for="password_confirm">Confirm Password*</label>
                                                <input name="password_confirm" type="password" placeholder="Confirm Password" id="password_confirm" required>
                                                <?php echo form_error('password_confirm', '<small class="text-danger mx-1">', '</small>'); ?>
                                            </div>
                                        </div>

                                        <div class="single-resume-feild feild-flex-2">
                                            <div class="single-input">
                                                <label for="profession">Profession*</label>
                                                <select name="profession" id="profession" required>
                                                    <option value="" <?php if(!set_value('profession')) echo 'selected'; ?> disabled>- Select Profession -</option>
                                                    <option value="Boss" <?php if(set_value('profession') == 'Boss') echo 'selected'; ?>>Boss</option>
                                                    <option value="Simple Employer" <?php if(set_value('profession') == 'Simple Employer') echo 'selected'; ?>>Simple Employer</option>
                                                </select>
                                            </div>

                                            <div class="single-input">
                                                <label for="switcherStatus">Status*</label>
                                                <div class="toggle_shop active_shop">
                                                    <span id="messageStatus"><?php if(set_value('active') == '1') { echo 'Active Employer'; } else { echo 'Inactive Employer'; } ?></span>&nbsp;
                                                    <label class="switch">
                                                        <input id="switcherStatus" type="checkbox" name="active" value="<?php if(set_value('active') == '1') { echo '1'; } else { echo '0'; } ?>" <?php if(set_value('active') == '1') echo 'checked'; ?>>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="submit-resume">
                                        <button type="submit" id="form-btn">&nbsp;Create&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Candidate Dashboard Area End -->
