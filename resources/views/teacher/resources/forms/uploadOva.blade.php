  <form id="ova-upload">                
	<label for="ova-file" >Upload OVA</label>
	<input type="file" class="ova-file" onchange='window.ovaSelectorScript("http://www.ocl.dev/api/teacher/upload/chunkupload", )' id="ova-file"><span><em>(OVA must match machine name)</em></span>
	<div class="progress">
	<div class="progress-bar bg-primary" id='ova-progress' role="progressbar" style="width:0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
	</div>
</form>