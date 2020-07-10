              <form id="new-{{$type}}" action="/teacher/create/{{$type}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="vm-name">Machine Name</label>
                  <input id="vm-name" name="vm-name" type="text" class = "form-control" placeholder="Your machine name MUST be the same as your ova file name. (<name>.ova)">
                  <div class="container my-3 d-flex justify-content-start" style="padding: 0px;">
                    <label for="pts" class="my-1 mx-2">Points</label>
                    <input type="number"  class="form-control" id="new-pts" name="pts" placeholder="(0-100)">
                    <label for="ip" class="my-1 mx-2">IP</label>
                    <input type="text"  class="form-control" id="new-ip" name="ip" placeholder="(XXX.XXX.XXX.XXX)">
                  </div>

                    <div class="container my-3 d-flex justify-content-start" style="padding: 0px;">
                      <label for="os-select" class="mx-2">OS</label>
                      <select id="os-select" class="custom-select mx-2 form-control" name="os-select" style="width:25%">
                        <option value="Linux">Linux</option>
                        <option value="Windows">Windows</option>
                        <option value="FreeBSD">FreeBSD</option>
                      </select>
                      <label for="icon-picker mx-2">Icon</label>
                      <input type="text" class="form-control mx-2 icon-picker" id="icon-picker" name="icon" placeholder="Pick one from the list or select directly" style="width:50%">
                      <button type="button" class="btn-primary mx-2 picker-button">Select</button><span class="demo-icon"></span>
                    </div>
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" rows="7"></textarea>
                    @if($type === 'lab')
                      <label for="level-count">Levels</label>
                      <input type="number" id="level-count" name="level-count" class="form-control" placeholder="1">
                    @endif
                    <label for="manual-flags" class="my-2">Manual Flags?</label><span><em> (Automatic flags change via flag rotation)</em></span>
                    <select id="manual-flags" class="custom-select form-control" name="manual-flags">
                      <option value="Manual">Manual</option>
                      <option value="Automatic">Automatic</option>
                    </select>

                    @if($type === 'b2r')
                    <div id="flags" style="padding:0px;">
                      <label for="user-flag" class="my-1">User Flag</label>
                      <input type="text" class="form-control" id="user-flag" name="user-flag">
                      <label for="root-flag" class="my-1">Root Flag</label>
                      <input type="text" class="form-control" id="root-flag" name="root-flag">
                    </div>
                    @elseif($type === 'lab')
                    <div id="flags" style="padding:0px;">
                    </div>
                    @endif
                    <input type="Submit" class="btn-primary mt-2" value="Add Machine">
                </div>
              </form>