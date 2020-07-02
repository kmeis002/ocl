<!-- Modal -->
<div class="modal fade" id="hintModal" tabindex="-1" role="dialog" aria-labelledby="hintModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hintModalLabel">Hint Warning!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <form>
          <input type="hidden" id="lab-name" name="lab-name" value="{{$vm->name}}">
          <input type="hidden" id="hint-num" name="hint-num" value="">
          <input type="hidden" id="is-root"  name="is-root"  value="test">
        </form>
        <button type="button" class="btn btn-secondary-trans" data-dismiss="modal">Close</button>
        <button type="button" id="reveal" class="btn btn-primary-trans">Reveal</button>
      </div>
    </div>
  </div>
</div>