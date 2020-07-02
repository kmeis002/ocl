		<nav class="navbar navbar-dark bg-dark justify-content-between sticky-top">
			<div>
				<a href="{{url()->previous() }}""><button type="button" class="btn btn-primary-trans"><i class="fas fa-chevron-left"></i></button></a>
				<a href="/presenter/home"><button type="button" class="btn btn-primary-trans"><i class="fas fa-home"></i></button></a>
			</div>
			<div> argot@ocl:~/labs$ </div>
			<div class="dropdown">
				<button type="button" class="btn btn-primary-trans"
						id="dropdownBars" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false"><i class="fas fa-bars drop-btn"></i>
				</button>
					<div class="dropdown-menu" aria-labelledby="dropdownBars">
						<a class="dropdown-item" href="#">Leaderboards</a>
						<a class="dropdown-item" href="#">Settings</a>
						<a class="dropdown-item" href="#">Logout</a>
					</div>
			</div>
		</nav>
