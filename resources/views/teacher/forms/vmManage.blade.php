<form id="vm-manage">
	<h5>Status	<span id="vm-status"></span>
	</h5>
	<p>Registered: <span id="vm-register-state"></span>
		<button type="button" class="btn btn-primary" id="register-vm" data-toggle="tooltip" data-placement="top" data-title="Register"><i class="fas fa-vote-yea"></i></button>
		<button type="button" class="btn btn-primary" id="unregister-vm" data-toggle="tooltip" data-placement="top" data-title="Unregister"><i class="fas fa-eraser"></i></button></p>
	<table id="vm-network-table">
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><label for="vm-network-mode" class="my-1">Network Mode</label>
					<select name="vm-network-select" class="form-control" name="vm-network-mode" id="vm-network-mode">
					<option value="NAT">NAT</option>
					<option value="Bridged">Bridged</option>
					</select>
				</td>
				<td class="align-bottom">
					<button type="button" class="btn  btn-primary mx-3" id="modify-network-mode"><i class="fas fa-pen"></i></button>
				</td>
				<td class="vm-bridged">
					<label for="vm-network-adapter" class="my-1">Network Adapter</label>
					<select name="vm-network-select" class="form-control" id="vm-bridged-adapter">
					</select>
				</td>
				<td class="align-bottom vm-bridged">
					<button type="button" class="btn btn-primary mx-3" id="modify-bridged-adapter"><i class="fas fa-pen"></i></button>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="vm-power">
		<button type="button" class="btn-primary btn my-3" id="vm-reset">Reset</button>
		<button type="button" class="btn-primary btn my-3" id="vm-power-toggle">Toggle Power</button>
	</div>



</form>