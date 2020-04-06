                <div class="col-md-12 col-lg-9">
                    <div class="dashboard-right">
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

                        <div class="browse-job-head-option">
                            <div class="manage-jobs-heading">
                                <h3 class="manage-employers-heading-custom">Manage Employers</h3>
                            </div>

                            <div class="company-list-btn">
                                <a href="/employers/addemployer" class="jobguru-btn">Create New</a>
                            </div>
                        </div>

                        <div class="candidate-list-page">
                            <?php foreach($employers as $employer) : ?>
                                <div class="single-candidate-list">
                                    <div class="main-comment">
                                        <div class="candidate-image">
                                            <img src="<?php if($employer['profession'] == 'Boss') { echo base_url('assets/img/uploads/companies/boss.png'); } else { echo base_url('assets/img/uploads/companies/employer.png'); }?>" alt="Employer Image">
                                        </div>

                                        <div class="candidate-text">
                                            <div class="candidate-info">
                                                <div class="candidate-title">
                                                    <h3><?php echo $employer['username']; ?></h3>
                                                    <h3 class="float-right"><span class="badge badge-<?php if($employer['active'] == '1') { echo 'secondary'; } else { echo 'warning'; } ?>"><?php if($employer['active'] == '1') { echo '&nbsp;Active&nbsp;'; } else { echo 'Inactive'; } ?></span></h3>
                                                </div>

                                                <p><?php echo $employer['profession']; ?></p>
                                            </div>

                                            <div class="candidate-text-bottom ">
                                                <div class="candidate-action">
                                                    <a href="<?php echo site_url('/employers/editemployer/'.$employer['id']); ?>" class="jobguru-btn-2">Edit</a>
                                                    <a href="#" class="jobguru-btn-danger" data-toggle="modal" data-target="#modal<?php echo $employer['id']; ?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="modal<?php echo $employer['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Delete Employer</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body text-center">Are you sure you want to delete <b><?php echo $employer['username']; ?></b>?</div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                                                <?php echo form_open('employers/deleteemployer/'.$employer['id'], 'class="form-inline"'); ?>
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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