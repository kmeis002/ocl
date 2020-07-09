              <form id="new-lab" action="/api/teacher/create/lab" method="POST">
                <div class="form-group">
                  <label for="vm-name">Machine Name</label>
                  <input id="vm-name" name="vm-name" type="text" class = "form-control" etvalue="Your machine name MUST be the same as your ova file name. (<name>.ova)">
                  <div class="container my-3 d-flex justify-content-start" style="padding: 0px;">
                    <label for="pts" class="my-1 mx-2">Points</label>
                    <input type="text"  class="form-control non-file" id="new-pts" name="pts" placeholder="(0-100)">
                    <label for="ip" class="my-1 mx-2">IP</label>
                    <input type="text"  class="form-control non-file" id="new-ip" name="ip" placeholder="(XXX.XXX.XXX.XXX)">
                  </div>

                    <div class="container my-3 d-flex justify-content-start" style="padding: 0px;">
                      <label for="os-select" class="mx-2">OS</label>
                      <select id="os-select" class="custom-select mx-2" name="os-select" style="width:25%">
                        <option value="Linux">Linux</option>
                        <option value="Windows">Windows</option>
                        <option value="FreeBSD">FreeBSD</option>
                      </select>
                      <label for="icon-picker mx-2">Icon</label>
                      <input type="text" class="form-control mx-2 icon-picker non-file" id="icon-picker" name="icon" placeholder="Pick one from the list or select directly" style="width:50%">
                      <button type="button" class="btn-primary mx-2 picker-button">Select</button><span class="demo-icon"></span>
                    </div>
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control non-file" rows="7"></textarea>

                    <label for="manual-flags" class="my-2">Manual Flags?</label><span><em> (Automatic flags change via flag rotation)</em></span>
                    <select id="manual-flags" class="custom-select" name="manual-flags">
                      <option value="Manual">Manual</option>
                      <option value="Automatic">Automatic</option>
                    </select>
                    <div id="flags" style="padding:0px;">
                      <label for="user-flag" class="my-1">User Flag</label>
                      <input type="text" class="form-control non-file" id="user-flag" name="user-flag">
                      <label for="root-flag" class="my-1">Root Flag</label>
                      <input type="text" class="form-control non-file" id="root-flag" name="root-flag">
                    </div>
                    <input type="Submit" class="btn-primary mt-2" value="Add Machine">
                </div>
              </form>