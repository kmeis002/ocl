<div id="side" class="side-menu-container">
	<div class="container d-flex justify-content-between">
		<span>{{Auth::user()->name}}</span>
		<span><a href="/teacher/logout"><i class="fas fa-sign-out-alt my-auto mx-1"></i></a></span>
	</div>
	<hr />
	<div class="container my-3">
		<h5>Manage Accounts</h5>

	<ul class="list-group">
		<li class="list-group-item"><a href="/teacher/accounts/teachers">Teacher Accounts</a></li>
		<li class="list-group-item"><a href="/teacher/accounts/students">Student Accounts</a></li>
	</ul>
    </div>
    <hr />
	<div class="container my-3">
		<h5>Manage Classes</h5>

	<ul class="list-group">
		<li class="list-group-item"><a href="/teacher/classes/list/course">Courses</a></li>
		<li class="list-group-item"><a href="/teacher/classes/list/class">Enrollment</a></li>
	</ul>
	</div>
	<hr />
	<div class="container my-3">
		<h5>Manage Classwork</h5>

	<ul class="list-group">
		<li class="list-group-item"><a href="/teacher/classwork/assignments">Assignments</a></li>
		<li class="list-group-item"><a href="/teacher/classwork/guides">Guides</a></li>
		<li class="list-group-item"><a href="/teacher/classwork/references">Quick References</a></li>
		<li class="list-group-item"><a href="#">Calendar</a></li>
	</ul>
	</div>
	<hr />
	<div class="container my-3">
		<h5>Manage Resources</h5>
	<ul class="list-group">
		<li class="list-group-item"><a href="/teacher/resources/list/b2r">Boot2Root Machines</a></li>
		<li class="list-group-item"><a href="/teacher/resources/list/lab">Lab Machines</a></li>
		<li class="list-group-item"><a href="/teacher/resources/list/ctf">Capture the Flags</a></li>
		<li class="list-group-item"><a href="/teacher/resources/skills">Skills</a></li>
	</ul>
	</div>
</div>