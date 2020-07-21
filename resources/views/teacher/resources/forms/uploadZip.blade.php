  <form id="ova-upload">                
  <label for="ova-file" >Upload Zip File</label>
  <input type="file" class="ova-file" onchange='window.selectorScript("http://www.ocl.dev/teacher/upload/zipupload", )' id="ova-file"><span><em>(Zip must match ctf challenge name)</em></span>
  <div class="progress">
  <div class="progress-bar bg-primary" id='ova-progress' role="progressbar" style="width:0%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
</form>