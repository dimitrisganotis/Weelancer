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
							<li class="active-breadcromb"><a href="">browse jobs</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcromb Area End -->


<!-- Top Job Area Start -->
<section class="jobguru-top-job-area browse-page section_70">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-3">
				<div class="job-grid-sidebar">
					<!-- Single Job Sidebar Start -->
					<div class="single-job-sidebar sidebar-location">
						<h3>Location</h3>
						<div class="job-sidebar-box">
							<form method="GET" accept-charset="utf-8" action="<?php echo site_url('jobs/jobslist'); ?>">
								<p><input autocomplete="off" name="address" type="text" id="searchInput"
										  value="<?php echo $filters['address']; ?>" placeholder="Search Location"></p>

								<?php if(!empty($filters['address']) && !empty($filters['lat']) && !empty($filters['long'])): ?>			
									<div class="input-group mb-3" style="border: 2px solid #e8ecec; border-radius: 5px">
										<input id="maxInput" name="max" type="number" class="form-control" style="border: 0; font-family: inherit; font-size: inherit;; line-height: inherit" placeholder="Max Distance" value="<?php echo $filters['max']; ?>">
										<div class="input-group-append" style="border: 0;">
											<span class="input-group-text" style="border: 0; border-radius: 0">km</span>
										</div>
									</div>
								<?php endif; ?>

								<div class="hiddeninputs">
									<input type="hidden" name="" id="location" value=""><br>
									<input type="hidden" name="" id="route" value=""><br>
									<input type="hidden" name="" id="street_number" value=""><br>
									<input type="hidden" name="" id="postal_code" value=""><br>
									<input type="hidden" name="" id="locality" value=""><br>
									<input type="hidden" name="lat" id="lat1" value="<?php if(!empty($filters['lat'])): echo $filters['lat']; endif; ?>"><br>
									<input type="hidden" name="lng" id="lng1" value="<?php if(!empty($filters['long'])): echo $filters['long']; endif; ?>">

									<?php if (!empty($filters['category'])): ?>
										<input type="hidden" name="category"
											   value="<?php echo $filters['category']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['type'])): foreach ($filters['type'] as $type): ?>
										<input type="hidden" name="type[]"
											   value="<?php echo strtolower(str_replace(" ", "_", $type)); ?>">
									<?php endforeach; endif; ?>

									<?php if (!empty($filters['search'])): ?>
										<input type="hidden" name="search" value="<?php echo $filters['search']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['sort'])): ?>
										<input type="hidden" name="sort" value="<?php echo $filters['sort']; ?>">
									<?php endif; ?>
								</div>

								<?php /*if (!is_null($filters['min']) && !is_null($filters['max'])): ?>
									<label style="margin: 10px 0">Distance: </label>
									<span id="maxkm"></span> -
									<span id="minkm"></span>

									<div id="slider-range"></div>
								<?php endif; */?>


								<button id="address-btn" type="submit" class="jobguru-btn mx-auto"
										style="padding: 5px; display: none">Search
								</button>
							</form>
						</div>
					</div>
					<!-- Single Job Sidebar End -->

					<!-- Single Job Sidebar Start -->
					<div class="single-job-sidebar sidebar-category">
						<h3>Category</h3>
						<div class="job-sidebar-box">
							<form method="GET" accept-charset="utf-8" action="<?php echo site_url('jobs/jobslist'); ?>">
								<select class="sidebar-category-select-2" name="category" onChange="this.form.submit()">
									<option value="all">Any Category</option>
									<?php foreach ($categories as $category): ?>
										<option <?php if (!empty($filters['category']) && $filters['category'] == $category) echo 'selected'; ?>
											value="<?php echo $category; ?>"><?php echo $category; ?></option>
									<?php endforeach; ?>
								</select>

								<div class="hiddeninputs">
									<?php if (!empty($filters['address'])): ?>
										<input type="hidden" name="address" value="<?php echo $filters['address']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['lat'])): ?>
										<input type="hidden" name="lat" value="<?php echo $filters['lat']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['long'])): ?>
										<input type="hidden" name="lng" value="<?php echo $filters['long']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['max'])): ?>
										<input type="hidden" name="max" value="<?php echo $filters['max']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['type'])): foreach ($filters['type'] as $type): ?>
										<input type="hidden" name="type[]"
											   value="<?php echo strtolower(str_replace(" ", "_", $type)); ?>">
									<?php endforeach; endif; ?>

									<?php if (!empty($filters['search'])): ?>
										<input type="hidden" name="search" value="<?php echo $filters['search']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['sort'])): ?>
										<input type="hidden" name="sort" value="<?php echo $filters['sort']; ?>">
									<?php endif; ?>
								</div>
							</form>
						</div>
					</div>
					<!-- Single Job Sidebar End -->

					<!-- Single Job Sidebar Start -->
					<div class="single-job-sidebar sidebar-type">
						<h3>job type</h3>
						<div class="job-sidebar-box">
							<form method="GET" accept-charset="utf-8" action="<?php echo site_url('jobs/jobslist'); ?>">
								<ul>
									<li class="checkbox">
										<input class="checkbox-spin" type="checkbox" id="Full_Time" name="type[]"
											   value="full_time" <?php if (!empty($filters['type']) && in_array('Full Time', $filters['type'])) echo 'checked'; ?>
											   onChange="this.form.submit()"/>
										<label for="Full_Time"><span></span>Full Time</label>
									</li>
									<li class="checkbox">
										<input class="checkbox-spin" type="checkbox" id="Part_Time" name="type[]"
											   value="part_time" <?php if (!empty($filters['type']) && in_array('Part Time', $filters['type'])) echo 'checked'; ?>
											   onChange="this.form.submit()"/>
										<label for="Part_Time"><span></span>Part Time</label>
									</li>
									<li class="checkbox">
										<input class="checkbox-spin" type="checkbox" id="Freelance" name="type[]"
											   value="freelance" <?php if (!empty($filters['type']) && in_array('Freelance', $filters['type'])) echo 'checked'; ?>
											   onChange="this.form.submit()"/>
										<label for="Freelance"><span></span>Freelance</label>
									</li>
									<li class="checkbox">
										<input class="checkbox-spin" type="checkbox" id="Internship" name="type[]"
											   value="internship" <?php if (!empty($filters['type']) && in_array('Internship', $filters['type'])) echo 'checked'; ?>
											   onChange="this.form.submit()"/>
										<label for="Internship"><span></span>Internship</label>
									</li>
								</ul>

								<div class="hiddeninputs">
									<?php if (!empty($filters['address'])): ?>
										<input type="hidden" name="address" value="<?php echo $filters['address']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['lat'])): ?>
										<input type="hidden" name="lat" value="<?php echo $filters['lat']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['long'])): ?>
										<input type="hidden" name="lng" value="<?php echo $filters['long']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['max'])): ?>
										<input type="hidden" name="max" value="<?php echo $filters['max']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['category'])): ?>
										<input type="hidden" name="category"
											   value="<?php echo $filters['category']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['search'])): ?>
										<input type="hidden" name="search" value="<?php echo $filters['search']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['sort'])): ?>
										<input type="hidden" name="sort" value="<?php echo $filters['sort']; ?>">
									<?php endif; ?>
								</div>
							</form>
						</div>
					</div>
					<!-- Single Job Sidebar End -->
				</div>
			</div>
			<div class="col-md-12 col-lg-9">
				<div class="job-grid-right">
					<div class="browse-job-head-option">
						<div class="job-browse-search">
							<form method="GET" accept-charset="utf-8" action="<?php echo site_url('jobs/jobslist'); ?>">
								<input type="search" name="search" value="<?php echo $filters['search']; ?>"
									   placeholder="Search Jobs Here...">
								<button type="submit"><i class="fa fa-search"></i></button>

								<div class="hiddeninputs">
									<?php if (!empty($filters['address'])): ?>
										<input type="hidden" name="address" value="<?php echo $filters['address']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['lat'])): ?>
										<input type="hidden" name="lat" value="<?php echo $filters['lat']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['long'])): ?>
										<input type="hidden" name="lng" value="<?php echo $filters['long']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['max'])): ?>
										<input type="hidden" name="max" value="<?php echo $filters['max']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['category'])): ?>
										<input type="hidden" name="category"
											   value="<?php echo $filters['category']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['type'])): foreach ($filters['type'] as $type): ?>
										<input type="hidden" name="type[]"
											   value="<?php echo strtolower(str_replace(" ", "_", $type)); ?>">
									<?php endforeach; endif; ?>

									<?php if (!empty($filters['sort'])): ?>
										<input type="hidden" name="sort" value="<?php echo $filters['sort']; ?>">
									<?php endif; ?>
								</div>
							</form>
						</div>
						<div class="job-browse-action">
							<form method="GET" accept-charset="utf-8" action="<?php echo site_url('jobs/jobslist'); ?>" id="forma">
								<div class="hiddeninputs">
									<?php if (!empty($filters['address'])): ?>
										<input type="hidden" name="address" value="<?php echo $filters['address']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['lat'])): ?>
										<input type="hidden" name="lat" value="<?php echo $filters['lat']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['long'])): ?>
										<input type="hidden" name="lng" value="<?php echo $filters['long']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['max'])): ?>
										<input type="hidden" name="max" value="<?php echo $filters['max']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['category'])): ?>
										<input type="hidden" name="category"
											   value="<?php echo $filters['category']; ?>">
									<?php endif; ?>

									<?php if (!empty($filters['type'])): foreach ($filters['type'] as $type): ?>
										<input type="hidden" name="type[]"
											   value="<?php echo strtolower(str_replace(" ", "_", $type)); ?>">
									<?php endforeach; endif; ?>
								</div>
								
								<select name="sort" class="select-filters ml-md-3" onChange="this.form.submit()">
									<option <?php if ($filters['sort'] == 'desc') echo 'selected'; ?> value="desc">Newest</option>
									<option <?php if ($filters['sort'] == 'asc') echo 'selected'; ?> value="asc">Oldest</option>

									<?php if(isset($jobs[0]['distance'])): ?>
										<option <?php if ($filters['sort'] == 'distance_asc') echo 'selected'; ?> value="distance_asc">Closer</option>
										<option <?php if ($filters['sort'] == 'distance_desc') echo 'selected'; ?> value="distance_desc">Further</option>
									<?php endif; ?>
								</select>
							</form>
						</div>
					</div>
					<!-- end job head -->
					<div class="job-sidebar-list-single">
						<?php if(empty($jobs)) { ?>
							<div class="sidebar-list-single border-0 mb-0">
								<div class="top-company-list justify-content-center">
									<p><b>There are not any posted jobs yet.</b></p>
								</div>
							</div>
						<?php } ?>

						<?php foreach ($jobs as $job) : ?>
							<div class="sidebar-list-single">
								<div class="top-company-list">
									<div class="company-list-logo">
										<a href="<?php echo site_url('jobs/details/' . $job['id']); ?>">
											<img src="<?php echo base_url($job['image']); ?>" alt="company list 1">
										</a>
									</div>
									<div class="company-list-details">
										<h3>
											<a href="<?php echo site_url('jobs/details/' . $job['id']); ?>"><?php echo $job['title']; ?></a>
										</h3>
										<p class="company-state"><i
												class="fa fa-map-marker"></i> <?php echo $job['address']; ?></p>
										<p class="company-state"><i
												class="fa fa-thumb-tack"></i> <?php echo $job['type']; ?></p>
										<p class="open-icon"><i
												class="fa fa-clock-o"></i><?php echo $job['created_at']; ?></p>
										<?php if (isset($job['distance'])): ?>
											<p class="open-icon"><i
													class="fa fa-road"></i><?php echo round($job['distance'], 1); ?> km
											</p>
										<?php endif; ?>
										<!--<p class="rating-company">4.1</p>-->
									</div>
									<div class="company-list-btn">
										<a href="<?php echo site_url('jobs/details/' . $job['id']); ?>"
										   class="jobguru-btn">Show More</a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<!-- end job sidebar list -->

					<?php if(!empty($jobs)): ?>
						<!-- start pagination -->
						<div class="pagination-box-row">
							<ul class="pagination">	
								<?php echo $pagination; ?>
							</ul>
						</div>
						<!-- end pagination -->
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Top Job Area End -->

<script>
    var address = document.getElementById('searchInput');
		var max = document.getElementById('maxInput');
    var button = document.getElementById('address-btn');

    address.onchange = function (e) {
        button.style.display = "block";
        button.style.marginTop = "20px";
    };

		max.onkeyup = function (e) {
        button.style.display = "block";
        button.style.marginTop = "20px";
    };
</script>
