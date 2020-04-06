<!-- Single Candidate Start -->
<section class="single-candidate-page section_70">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="single-candidate-box">
					<div class="single-candidate-img">
						<img src="<?php echo base_url($company['image']); ?>" alt="single candidate"/>
					</div>
					<div class="single-candidate-box-right">
						<h4><?php echo $company['title']; ?></h4>
						<p><?php echo $company['category']; ?></p>
						<div class="job-details-meta">
							<p><i class="fa fa-file-text"></i> Open Positions: <?php echo $total_jobs; ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="single-candidate-action">
					<a href="#" class="bookmarks" data-toggle="modal" data-target="#modal_viewonmap"><i
							class="fa fa-map-marker"></i>See on map</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Single Candidate End -->

<!-- Modal -->
<div class="modal fade" id="modal_viewonmap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-bold" id="exampleModalLabel"><?php echo $company['address']; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body text-center">
				<div id="viewmap"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Single Candidate Bottom Start -->
<div class="single-candidate-bottom-area section_70">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-8">
				<div class="single-candidate-bottom-left">
					<div class="single-candidate-widget">
						<h3>company description</h3>
						<p><?php echo $company['description']; ?></p>
					</div>
					<div class="single-candidate-widget" id="postedjobs">
						<?php if($total_jobs > 0): ?>
							<h3>(<?php echo $total_jobs; ?>) Open Positions</h3>
							<?php foreach($jobs as $job): ?>
								<div class="single-work-history company-single-page">
									<div class="single-candidate-list">
										<div class="main-comment">
											<div class="candidate-text">
												<div class="candidate-info">
													<div class="candidate-title">
														<h3><a href="<?php echo site_url('jobs/details/' . $job['id']); ?>"><?php echo $job['title']; ?></a></h3>
													</div>
													<p class="company-state"><i class="fa fa-map-marker"></i> <?php echo $job['address']; ?></p>
													<p class="company-state"><i class="fa fa-thumb-tack"></i> <?php echo $job['type']; ?></p>
													<p class="open-icon"><i class="fa fa-clock-o"></i><?php echo $job['created_at']; ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-4">
				<div class="single-candidate-bottom-right">
					<div class="single-candidate-widget-2">
						<h3>Basic info</h3>
						<ul>
							<li><i class="fa fa-envelope"></i> <?php echo $company['email']; ?></li>
							<?php if(!empty($company['phone'])): ?><li><i class="fa fa-phone"></i> <?php echo $company['phone']; ?></li><?php endif; ?>
							<?php if(!empty($company['website'])): ?><li><i class="fa fa-globe"></i> <a style="color: #333" href="<?php echo $company['website']; ?>" target="_blank"><?php echo $company['website']; ?></a></li><?php endif; ?>
						</ul>
					</div>
					<?php if (!empty($company['facebook']) && !empty($company['linkedin'])) {
						?>
						<div class="single-candidate-widget-2">
							<h3>Social Links</h3>
							<ul class="candidate-social">
								<?php if (!empty($company['facebook'])) { ?>
									<li><a href="<?php echo $company['facebook']; ?>" target="_blank"><i
											class="fa fa-facebook"></i></a></li><?php } ?>
								<?php if (!empty($company['linkedin'])) { ?>
									<li><a href="<?php echo $company['linkedin']; ?>" target="_blank"><i
											class="fa fa-linkedin"></i></a></li><?php } ?>
							</ul>
						</div>
					<?php }
					?>
					<div class="single-candidate-widget-2">
						<h3>Quick Contact</h3>
						<?php echo form_open('jobs/company/'.$company['id'], 'id="form"') ?>
							<?php if($this->session->flashdata('status')) { ?><p class="minima"><strong><?php echo $this->session->flashdata('status'); ?></strong></p><?php } ?>
							<p>
								<input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="Your Name" required>
								<?php echo form_error('username', '<small class="text-danger mx-1">', '</small>'); ?>
							</p>
							<p>
								<input type="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Your Email Address" required>
								<?php echo form_error('email', '<small class="text-danger mx-1">', '</small>'); ?>
							</p>
							<p>
								<textarea placeholder="Write here your message" name="message"><?php echo set_value('message'); ?></textarea>
								<?php echo form_error('message', '<small class="text-danger mx-1">', '</small>'); ?>
							</p>
							<p>
								<button id="form-btn" type="submit">&nbsp;Send Message&nbsp;<i class='fa fa-spinner fa-spin' style="display:none;"></i></button>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Single Candidate Bottom End -->

<script>
   window.setTimeout(function () {
      $(".minima").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
      });
   }, 3000);
</script>
<script>
    var lat = <?php echo $company['lat']; ?>;
    var lng = <?php echo $company['long']; ?>;

    var myLatLng = {lat: lat, lng: lng};

    var map = new google.maps.Map(document.getElementById('viewmap'), {
        zoom: 15,
        center: myLatLng
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map
    });
</script>
