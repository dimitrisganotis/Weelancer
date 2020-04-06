<div hidden id="mapview"></div>
<!-- Breadcromb Area Start -->
<section class="jobguru-breadcromb-area">
    <div class="breadcromb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcromb-box-pagin">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li class="active-breadcromb"><a href="">Sign up company</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcromb Area End -->

<!-- Login Area Start -->
<section class="jobguru-submit-resume-area section_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="submit-resume-box">
                    <?php echo form_open_multipart('employers/signup', 'id="form"') ?>
                        <div class="single-resume-feild resume-avatar">
                            <div class="resume-image">
                                <img class="file-upload-image" src="<?php echo base_url(); ?>assets/img/resume-avatar.jpg" alt="resume avatar"/>
                            </div>

                            <div class="file-upload">
                                <div class="image-upload-wrap">
                                    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" name="image"/>

                                    <div class="drag-text">
                                        <h3 style="border: none;">Drag and drop a file or select your image</h3>
                                    </div>
                                </div>

                                <div class="file-upload-content">
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                    </div>
                                </div>

                                <?php echo form_error('image', '<small class="text-danger mx-1">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="resume-box">
                            <h3>Company Information</h3>
                            <div class="single-resume-feild feild-flex-2">
                                <div class="single-input">
                                    <label for="title">Title*</label>
                                    <input name="title" type="text" placeholder="Company's title" id="title" value="<?php echo set_value('title'); ?>" required>
                                    <?php echo form_error('title', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>

                                <div class="single-input">
                                    <label for="category">Category*</label>
                                    <select name="category" id="category" required>
                                        <option disabled <?php if (!set_value('category')) echo 'selected'; ?>>- Select Category -</option>
                                        <?php foreach($categories as $category): ?>
                                            <option <?php if(set_value('category') == $category) echo 'selected'; ?> value="<?php echo $category ?>"><?php echo $category ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <?php echo form_error('category', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="single-resume-feild feild-flex-2">
                                <div class="single-input">
                                    <label for="email">Email*</label>
                                    <input name="email" type="email" placeholder="Company's Email" id="email" value="<?php echo set_value('email'); ?>" required>
                                    <?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>

                                <div class="single-input">
                                    <label for="phone">Phone</label>
                                    <input name="phone" type="tel" placeholder="Phone Number" id="phone" value="<?php echo set_value('phone'); ?>">
                                    <?php echo form_error('phone', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="single-resume-feild feild-flex-2">
                                <div class="single-input">
                                    <label for="address">Address*</label>
                                    <input autocomplete="off" name="address" type="text" id="searchInput" placeholder="Street Address" id="address" value="<?php echo set_value('address'); ?>" required>
                                    <?php echo form_error('address', '<small class="text-danger mx-1">', '</small>'); ?>

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

                                <div class="single-input">
                                    <label for="start">Start year*</label>
                                    <input name="start" type="number" placeholder="Start year" id="start" min="1870" max="<?php echo date("Y"); ?>" value="<?php echo set_value('start'); ?>" required>
                                    <?php echo form_error('start', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="single-resume-feild ">
                                <div class="single-input">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="tinymce" placeholder="Write a summary of company ..."><?php echo set_value('description'); ?></textarea>
                                    <?php echo form_error('description', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="resume-box">
                            <h3>Social Links</h3>
                            <div class="single-resume-feild feild-flex-2">
                                <div class="single-input">
                                    <label for="facebook"><i class="fa fa-facebook facebook"></i>Facebook</label>
                                    <input name="facebook" type="text" placeholder="Facebook URL" id="facebook" value="<?php echo set_value('facebook'); ?>">
                                    <?php echo form_error('facebook', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>

                                <div class="single-input">
                                    <label for="linkedin"><i class="fa fa-linkedin linkedin"></i>LinkedIn</label>
                                    <input name="linkedin" type="text" placeholder="LinkedIn URL" id="linkedin" value="<?php echo set_value('linkedin'); ?>">
                                    <?php echo form_error('linkedin', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="single-resume-feild ">
                                <div class="single-input">
                                    <label for="website">Website</label>
                                    <input name="website" type="text" placeholder="Company's website" id="website" value="<?php echo set_value('website'); ?>">
                                    <?php echo form_error('website', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="resume-box">
                            <h3>Employer info</h3>
                            <div class="single-resume-feild feild-flex-2">
                                <div class="single-input">
                                    <label for="username">Full Name*</label>
                                    <input name="username" type="text" placeholder="Enter your name and surname" id="username" value="<?php echo set_value('username'); ?>" required>
                                    <?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>

                                <div class="single-input">
                                    <label for="employer_email">Email*</label>
                                    <input name="employer_email" type="email" placeholder="Enter your email" id="employer_email" value="<?php echo set_value('employer_email'); ?>" required>
                                    <?php echo form_error('employer_email', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="single-resume-feild feild-flex-2">
                                <div class="single-input">
                                    <label for="password">Password*</label>
                                    <input name="password" type="password" pattern=".{4,}" title="Four or more characters" placeholder="Enter your password" id="password" required>
                                    <?php echo form_error('password', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>

                                <div class="single-input">
                                    <label for="password_confirm">Confirm Password*</label>
                                    <input name="password_confirm" type="password" pattern=".{4,}" title="Four or more characters" placeholder="Enter your password again" id="password_confirm" required>
                                    <?php echo form_error('password_confirm', '<small class="text-danger mx-1">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="submit-resume">
                            <button id="form-btn" type="submit">&nbsp;Create Company&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Submit Resume Area End -->
<!-- Login Area End -->