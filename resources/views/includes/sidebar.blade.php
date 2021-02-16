<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scrollbar-inner">
		<!-- Brand -->
		<div class="sidenav-header d-flex align-items-center">
			<a class="navbar-brand" href="javascript:void(0)">
				<h1>Rejuvaskin</h1>
			</a>
			<div class="ml-auto">
				<!-- Sidenav toggler -->
				<div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
					<div class="sidenav-toggler-inner">
						<i class="sidenav-toggler-line"></i>
						<i class="sidenav-toggler-line"></i>
						<i class="sidenav-toggler-line"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar-inner">
			<!-- Collapse -->
			<div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <h6 class="heading-small text-muted">Patient Records</h6>
				<!-- Nav items -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="{{ url('dashboard') }}" id="dashboard">
							<i class="ni ni-tv-2 text-primary"></i>
							<span class="nav-link-text">Dashboard</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ url('calendar') }}" id="calendar">
							<i class="ni ni-calendar-grid-58 text-success"></i>
							<span class="nav-link-text">Calendar</span>
						</a>
					</li>
					<li class="nav-item show" id="patient-dropdown">
						<a class="nav-link collapsed" href="#navbar-patient-info" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-patient-info">
							<i class="ni ni-single-02 text-danger"></i>
							<span class="nav-link-text">Patients</span>
						</a>
						<div class="collapse" id="navbar-patient-info">
							<ul class="nav nav-sm flex-column">
								<li class="nav-item">
									<a id="patient-information" href="{{ url('patient-information') }}" class="nav-link">
										<i class="ni ni-bullet-list-67 text-danger"></i> Patient List
									</a>
								</li>
								<li class="nav-item">
									<a id="add-patient-information" href="{{ url('add-patient-information') }}" class="nav-link"><i class="fas fa-user-plus text-danger"></i> Add Patient Information</a>
								</li>
							</ul>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ url('inventory-list') }}" id="inventory-list">
							<i class="fas fa-prescription-bottle text-warning"></i>
                            <span class="nav-link-text">Inventory</span>
						</a>
					</li>
				</ul>
				<!-- Divider -->
				<hr class="my-3">

                <h6 class="heading-small text-muted">Employees Records</h6>
                <ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="{{ url('time-keeping') }}" id="time-keeping">
							<i class="fas fa-clock text-default"></i>
							<span class="nav-link-text">Time Keeping</span>
						</a>
					</li>
                    {{-- <li class="nav-item">
						<a class="nav-link" href="{{ url('time-keeping-disputes') }}" id="time-keeping-disputes">
							<i class="fas fa-calendar-check text-warning"></i>
							<span class="nav-link-text">Time Keeping Disputes</span>
						</a>
					</li> --}}
					<li class="nav-item">
						<a class="nav-link" href="{{ url('leaves') }}" id="leaves">
							<i class="fas fa-file-invoice text-primary"></i>
							<span class="nav-link-text">Leave Applications</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
