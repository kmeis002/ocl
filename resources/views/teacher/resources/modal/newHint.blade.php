<!-- Modal -->
<div class="modal fade" id="newHintModal" tabindex="-1" role="dialog" aria-labelledby="newHintModalLabel" aria-hidden="true" data-name="">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newHintModalLabel">Add New Hint</h5>
        <button type="button" class="close close-new-hint"aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div>
          @include('teacher.resources.forms.newHint')
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary-trans close-new-hint">Close</button>
      </div>
    </div>
  </div>
</div>