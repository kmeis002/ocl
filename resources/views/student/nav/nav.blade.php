		<nav class="navbar navbar-dark bg-dark justify-content-between sticky-top">
			<div>
				<a href="{{url()->previous() }}"><button type="button" class="btn btn-primary-trans"><i class="fas fa-chevron-left"></i></button></a>
				<a href="/student/"><button type="button" class="btn btn-primary-trans"><i class="fas fa-home"></i></button></a>
			</div>
			<div> {{Auth::user()->name}}@ocl:~/{{Request::path()}}$  </div>
			<div class="dropdown">
				<button type="button" class="btn btn-primary-trans"
						id="dropdownBars" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false"><i class="fas fa-bars drop-btn"></i>
				</button>
					<div class="dropdown-menu" aria-labelledby="dropdownBars">
						<a class="dropdown-item" href="#">Leaderboards</a>
						<a class="dropdown-item" href="#">Settings</a>
						<a class="dropdown-item" href="/student/logout">Logout</a>
					</div>
			</div>
		</nav>
