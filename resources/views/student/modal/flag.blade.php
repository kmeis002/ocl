<!-- Modal -->
<div class="modal fade" id="flagModal" tabindex="-1" role="dialog" aria-labelledby="flagModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="flagModalLabel">Submit Flag</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Flag:</label>
            <input type="text" class="form-control" id="flag">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary-trans" data-dismiss="modal">Close</button>
        <button type="button" id="submit-flag" class="btn btn-primary-trans" data-name="" data-flag-id="" data-type="{{$type}}">Submit</button>
      </div>
    </div>
  </div>
</div>