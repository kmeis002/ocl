<!-- Modal -->
<div class="modal fade" id="uploadOvaModal" tabindex="-1" role="dialog" aria-labelledby="uploadOvaModalLabel" aria-hidden="true" data-name="">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadOvaModalLabel">Upload Virtual Machine</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div>
          @include('teacher.forms.uploadOva')
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary-trans" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>