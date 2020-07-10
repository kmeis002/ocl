<!-- Modal -->
<div class="modal fade" id="createlabModal" tabindex="-1" role="dialog" aria-labelledby="createlabModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createlabModalLabel">Create New Lab</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div>
          @include('teacher.resources.forms.newMachine')
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary-trans" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>