         <div class="col-lg-9 col-md-12">
            <div class="dashboard-right">
               <div class="manage-jobs">
                  <div class="manage-jobs-heading">
                     <h3>My Job Listing</h3>
                  </div>

                  <div class="single-manage-jobs table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th>Title</th>
                              <th>Posted on</th>
                              <th>Applied on</th>
                              <th>Status</th>
                           </tr>
                        </thead>

                        <tbody>
                           <?php foreach($applications as $application): ?>
                              <tr>
                                 <td class="manage-jobs-title"><a href="<?php echo site_url('jobs/details/'.$application['id']); ?>"><?php echo $application['title'] ?></a></td>
                                 <td class="table-date"><?php echo $application['j_created_at'] ?></td>
                                 <td class="table-date"><?php echo $application['a_created_at'] ?></td>
                                 <td><span class="badge badge-<?php if($application['state'] == "Pending"): echo "info"; elseif($application['state'] == "Approved"): echo "success"; elseif($application['state'] == "Rejected"): echo "danger"; else: echo "dark"; endif; ?>"><?php echo $application['state'] ?></span></td>
                              </tr>
                           <?php endforeach; ?>                                 
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Candidate Dashboard Area End -->
