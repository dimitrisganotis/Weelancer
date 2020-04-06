            <div hidden id="mapview"></div>
            <div class="col-md-12 col-lg-9">
                <div class="dashboard-right">
                    <div class="candidate-profile">
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

                        <?php echo form_open_multipart('employers/profile', 'id="form"') ?>
                            <div class="candidate-single-profile-info">
                                <div class="single-resume-feild resume-avatar">
                                    <div class="resume-image company-resume-image">
                                        <img class="file-upload-image" src="<?php echo base_url($company['image']); ?>" alt="resume avatar">
                                    </div>
                                </div>

                                <div class="file-upload">
                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" name="image"/>
                                        <div class="drag-text">
                                            <h3>Drag and drop a file or select your image</h3>
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

                            <div class="candidate-single-profile-info">
                                <div class="resume-box">
                                    <h3>Company Information</h3>
                                    <div class="single-resume-feild feild-flex-2">
                                        <div class="single-input">
                                            <label for="title">Title*</label>
                                            <input name="title" type="text" placeholder="Company's title" id="title" value="<?php echo $company['title']; ?>">
                                            <?php echo form_error('title', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>

                                        <div class="single-input">
                                            <label for="category">Category*</label>
                                            <select name="category" id="category">
                                                <option disabled>Select Category</option>
                                                <?php foreach($categories as $category): ?>
                                                    <option <?php if($company['category'] == $category) echo 'selected'; ?> value="<?php echo $category ?>"><?php echo $category ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('category', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="single-resume-feild feild-flex-2">
                                        <div class="single-input">
                                            <label for="email">Email*</label>
                                            <input name="email" type="email" placeholder="Company's Email" id="email" value="<?php echo $company['email']; ?>" required>
                                            <?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>

                                        <div class="single-input">
                                            <label for="phone">Phone</label>
                                            <input name="phone" type="tel" placeholder="Phone Number" id="phone" value="<?php echo $company['phone']; ?>">
                                            <?php echo form_error('phone', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="single-resume-feild feild-flex-2">
                                        <div class="single-input">
                                            <label for="searchInput">Address*</label>
                                            <input autocomplete="off" name="address" type="text" id="searchInput" placeholder="Enter your Address" value="<?php echo $company['address']; ?>" required>
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

                                        <div class="single-input">
                                            <label for="start">Start year*</label>
                                            <input name="start" type="number" placeholder="Start year" id="start" min="1870" max="<?php echo date("Y"); ?>" value="<?php echo $company['start']; ?>" required>
                                            <?php echo form_error('start', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="single-resume-feild ">
                                        <div class="single-input">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="escription" class="tinymce" placeholder="Write a summary of company..."><?php echo $company['description']; ?></textarea>
                                            <?php echo form_error('description', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="resume-box">
                                    <h3>Social Links</h3>
                                    <div class="single-resume-feild feild-flex-2">
                                        <div class="single-input">
                                            <label for="facebook"><i class="fa fa-facebook facebook"></i>Facebook</label>
                                            <input name="facebook" type="text" placeholder="Facebook URL" id="facebook" value="<?php echo $company['facebook']; ?>">
                                            <?php echo form_error('facebook', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>

                                        <div class="single-input">
                                            <label for="linkedin"><i class="fa fa-linkedin linkedin"></i>LinkedIn</label>
                                            <input name="linkedin" type="text" placeholder="Linkedin URL" id="linkedin" value="<?php echo $company['linkedin']; ?>">
                                            <?php echo form_error('linkedin', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>
                                    </div>

                                    <div class="single-resume-feild ">
                                        <div class="single-input">
                                            <label for="website">Website</label>
                                            <input name="website" type="text" placeholder="Company's website" id="website" value="<?php echo $company['website']; ?>">
                                            <?php echo form_error('website', '<small class="text-danger mx-1">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="submit-resume">
                                    <button type="submit" id="form-btn">&nbsp;Update&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
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
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 2000);
</script>