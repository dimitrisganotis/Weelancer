                <br>
            <div class="col-md-12 col-lg-9">
                <div class="job-grid-right">
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
                            <h3 class="manage-employers-heading-custom">
                                <?php if($flag == 'pending'): echo 'Pending Candidates'; else: echo 'Approved Candidates'; endif;?>
                            </h3>
                        </div>

                        <div class="company-list-btn">
                            <?php if($flag == 'pending'): ?>
                                <a href="<?php echo site_url('employers/managecandidates/'.$job_id.'?status=approved'); ?>" class="jobguru-btn">Approved Candidates</a>
                            <?php elseif($flag == 'approved'): ?>
                                <a href="<?php echo site_url('employers/managecandidates/'.$job_id.'?status=pending'); ?>" class="jobguru-btn">Pending Candidates</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="candidate-list-page">
                        <?php foreach($candidates as $candidate): ?>
                            <div class="single-candidate-list">
                                <div class="main-comment">
                                    <div class="candidate-image">
                                        <img src="<?php echo base_url($candidate['image']); ?>" alt="author">
                                    </div>

                                    <div class="candidate-text">
                                        <div class="candidate-info">
                                            <div class="candidate-title">
                                                <h3><?php echo $candidate['username']; ?></h3>
                                            </div>
                                            <p><?php echo $candidate['profession']; ?></p>
                                        </div>

                                        <div class="candidate-text-bottom">
                                            <div class="candidate-text-box">
                                                <p class="open-icon"><i class="fa fa-clock-o"></i> <?php echo $candidate['created_at']; ?></p>
                                            </div>

											<div class="candidate-action">
												<a href="<?php echo site_url('employers/viewcandidate/'.$candidate['application_id']); ?>" class="jobguru-btn-2 viewprofile" style="background-color: #17a2b8; border: 0; color: white">View Profile</a>
												<?php if($flag == 'pending'): ?>
                                                    <a href="<?php echo site_url('employers/candidate_approval/'.$candidate['application_id']); ?>" class="jobguru-btn-2" onclick="return confirm_approval();">Approve</a>
                                                    <a href="<?php echo site_url('employers/candidate_rejection/'.$candidate['application_id']); ?>" class="jobguru-btn-danger" onclick="return confirm_rejection();">Decline</a>
                                                <?php endif; ?>
											</div>
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
</section>
<!-- Candidate Area End -->

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 2000);

    function confirm_approval() {
        return confirm("Are you sure about the approval?");
    }

    function confirm_rejection() {
        return confirm("Are you sure about the rejection?");
    }
</script>
