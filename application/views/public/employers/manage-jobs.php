                <div hidden id="mapview"></div>
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

                        <div class="earnings-page-box manage-jobs">
                            <div class="manage-jobs-heading">
                                <h3>Manage jobs</h3>
                            </div>

                            <div class="job-grid-right">
                                <!-- end job head -->
                                <div class="job-sidebar-list-single">
                                    <?php if(empty($jobs)): ?>
                                        <div class="sidebar-list-single border-0 mb-0">
                                            <div class="top-company-list justify-content-center">
                                                <p><b>There are not any posted jobs yet.</b></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php foreach($jobs as $job): ?>
                                        <div class="sidebar-list-single">
                                            <div class="top-company-list">
                                                <div class="company-list-details">
                                                    <h3><a href="<?php echo site_url('/employers/editjob/'.$job['id']); ?>"><?php echo $job['title']; ?></a></h3>
                                                    <p class="company-state"><i class="fa fa-map-marker"></i> <?php echo $job['address']; ?></p>
                                                    <p class="open-icon"><i class="fa fa-clock-o"></i><?php echo $job['created_at']; ?></p>
                                                    <p class="varify"><i class="fa fa-eur"></i>Salary: <?php echo $job['salary']; ?>&euro;</p>
                                                </div>

                                                <div class="company-list-btn">
                                                    <a href="/employers/managecandidates/<?php echo $job['id']; ?>?status=pending" class="jobguru-btn">Applicants</a>
                                                </div>
                                            </div>

                                            <div class="candidate-text-bottom ">
                                                <div class="candidate-action">
                                                    <a href="<?php echo site_url('/employers/editjob/'.$job['id']); ?>" class="jobguru-btn-2">Edit</a>
                                                    <a href="#" class="jobguru-btn-danger" data-toggle="modal" data-target="#modal<?php echo $job['id']; ?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal<?php echo $job['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Delete Job</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body text-center">Are you sure you want to delete <b><?php echo $job['title']; ?></b>?</div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <?php echo form_open('employers/deletejob/'.$job['id'], 'class="form-inline"'); ?>
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
