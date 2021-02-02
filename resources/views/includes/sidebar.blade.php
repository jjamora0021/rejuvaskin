<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scrollbar-inner">
		<!-- Brand -->
		<div class="sidenav-header  align-items-center">
			<a class="navbar-brand" href="javascript:void(0)">
				<h1>Rejuvaskin</h1>
			</a>
		</div>
		<div class="navbar-inner">
			<!-- Collapse -->
			<div class="collapse navbar-collapse" id="sidenav-collapse-main">
				<!-- Nav items -->
				<ul class="navbar-nav">
					<li class="nav-item" id="dashboard-link">
						<a class="nav-link" href="{{ url('dashboard') }}">
							<i class="ni ni-tv-2 text-primary"></i>
							<span class="nav-link-text">Dashboard</span>
						</a>
					</li>
					<li class="nav-item" id="patient-information">
						<a class="nav-link" href="{{ url('patient-information') }}">
							<i class="ni ni-single-02 text-danger"></i>
							<span class="nav-link-text">Patients</span>
						</a>
					</li>
				</ul>
				<!-- Divider -->
				<hr class="my-3">
			</div>
		</div>
	</div>
</nav>