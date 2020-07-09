<!-- Modal -->
<div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="iconModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="iconModalLabel">Icon Selector</h5>
        <button type="button" class="icon-close close" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body" style="word-break:break-all">
        <div>
          <label for="icon-filter">Search</label>
          <input type="text" class="form-control" id="icon-filter">
        </div>
        <div>
          <ul class="icon-picker-list">
            <li class="icon-list-item" style="max-height: 50px; height: 50px">
              <a data-class="{item} {activeState}" data-index="{index}" >
                <span class="{item} fa-2x"></span>
                <span class="name-class" style="visibility: hidden">{item}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="icon-close btn btn-secondary-trans">Close</button>
        <button type="button" id="change-icon" class="btn btn-success">
          <span class="fa fa-check-circle-o"></span>
          Use Selected Icon
        </button>
      </div>
    </div>
  </div>
</div>