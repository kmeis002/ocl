<div class="container d-flex justify-content-center main-list my-3" style="max-width: 2000px">
	<div class="container">
		<h4>Outstanding assignments</h4>
		<table class = "table table-dark table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Details</th>
					<th>Due Date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($completed as $c)
				<tr>
					@if($c->prefix === 'Lab')
					<td>{{$c->lab->lab_name}}</td>
					<td>{{$c->prefix}}:<br>Level {{$c->lab->start_level}} to Level {{$c->lab->end_level}}</td>
					@elseif($c->prefix === 'B2R')
					<td>{{$c->b2r->b2r_name}}</td>
					<td>{{$c->prefix}}:<br>{{($c->b2r->user === 1) ? 'Must Complete' : 'false'}} User  <br>{{($c->b2r->root === 1) ? 'Must Complete' : 'Do not need to complete'}} Root </td>
					@elseif($c->prefix === 'CTF')
					<td>{{$c->ctf->ctf_name}}</td>
					<td>{{$c->prefix}}</td>
					@endif
					<td>{{date("F d Y", strtotime($c->end_date))}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="container">
		<h4>Completed assignments</h4>
		<table class = "table table-dark table-striped table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Details</th>
					<th>Due Date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($incomplete as $c)
				<tr>
					@if($c->prefix === 'Lab')
					<td>{{$c->lab->lab_name}}</td>
					<td>{{$c->prefix}}:<br>Level {{$c->lab->start_level}} to Level {{$c->lab->end_level}}</td>
					@elseif($c->prefix === 'B2R')
					<td>{{$c->b2r->b2r_name}}</td>
					<td>{{$c->prefix}}:<br>{{($c->b2r->user === 1) ? 'Must Complete' : 'false'}} User  <br>{{($c->b2r->root === 1) ? 'Must Complete' : 'Do not need to complete'}} Root </td>
					@elseif($c->prefix === 'CTF')
					<td>{{$c->ctf->ctf_name}}</td>
					<td>{{$c->prefix}}</td>
					@endif
					<td>{{date("F d Y", strtotime($c->end_date))}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</div>
