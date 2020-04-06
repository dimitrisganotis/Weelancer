         <div hidden id="mapview"></div>
         <div class="col-md-12 col-lg-9">
            <div class="dashboard-right">
               <div class="earnings-page-box manage-jobs">
                  <div class="manage-jobs-heading">
                     <h3>Post A new job</h3>
                  </div>

                  <div class="new-job-submission">
                     <?php echo form_open('employers/postjob', 'id="form"') ?>
                        <div class="single-resume-feild feild-flex-2">
                           <div class="single-input">
                              <label for="title">Job Title*</label>
                              <input type="text" id="title" name="title" placeholder="Enter Job's Title" value="<?php echo set_value('title'); ?>" required>
                              <?php echo form_error('title', '<small class="text-danger mx-1">', '</small>'); ?>
                           </div>

                           <div class="single-input">
                              <label for="category">Job Category*</label>
                              <select id="category" name="category" required>
                                 <option value='' <?php if(!set_value('category')) echo 'selected'; ?> disabled>- Select Job's Category -</option>
                                 <?php foreach($categories as $category): ?>
                                    <option <?php if(set_value('category') == $category) echo 'selected'; ?> value="<?php echo $category ?>"><?php echo $category ?></option>
                                 <?php endforeach; ?>
                              </select>
                              <?php echo form_error('category', '<small class="text-danger mx-1">', '</small>'); ?>
                           </div>
                        </div>

                        <div class="single-resume-feild">
                           <div class="single-input">
                                 <label for="searchInput">Job Location:</label>
                                 <input autocomplete="off" name="address" type="text" id="searchInput" placeholder="Enter job's Address"
                                       value="<?php echo set_value('address'); ?>" required>
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

                        <div class="single-resume-feild feild-flex-2">
                           <div class="single-input">
                              <label for="type">Job Type*</label>
                              <select id="type" name="type" required>
                                 <option value='' <?php if(!set_value('type')) echo 'selected'; ?> disabled>- Select Job's Type -</option>
                                 <option value="Full Time" <?php if(set_value('type') == "Full Time") echo 'selected'; ?>>Full TIme</option>
                                 <option value="Freelance" <?php if(set_value('type') == "Freelance") echo 'selected'; ?>>Freelance</option>
                                 <option value="Part Time" <?php if(set_value('type') == "Part Time") echo 'selected'; ?>>Part Time</option>
                                 <option value="Internship" <?php if(set_value('type') == "Internship") echo 'selected'; ?>>Internship</option>
                              </select>
                              <?php echo form_error('type', '<small class="text-danger mx-1">', '</small>'); ?>
                           </div>

                           <div class="single-input">
                              <label for="salary">Salary (&euro; per month)</label>
                              <input type="number" placeholder="Enter Job's Salary Per Month e.g. 1800" id="salary" name="salary" value="<?php echo set_value('salary'); ?>" min="0" max="100000">
                              <?php echo form_error('salary', '<small class="text-danger mx-1">', '</small>'); ?>
                           </div>
                        </div>
                        
                        <div class="single-resume-feild">
                           <div class="single-input">
                              <label for="description">Job Description*</label>
                              <textarea id="description" class="tinymce" name="description" placeholder="Enter Job's Description"><?php echo set_value('description'); ?></textarea>
                              <?php echo form_error('description', '<small class="text-danger mx-1">', '</small>'); ?>
                           </div>
                        </div>

                        <div class="single-input submit-resume">
                           <button type="submit" id="form-btn">&nbsp;Post Job&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
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