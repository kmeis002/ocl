              <form id="edit-lab" action="/teacher/edit/{{$type}}/" method="POST">
                @csrf
                <div class="form-group">
                  <p>Machine Name: <span id="edit-vm-name"></span></p>
                  <div class="container my-3 d-flex justify-content-start" style="padding: 0px;">
                    <label for="edit-pts" class="my-1 mx-2">Points</label>
                    <input type="text"  class="form-control" id="edit-pts" name='edit-pts' placeholder="(0-100)">
                    <label for="ip" class="my-1 mx-2">IP</label>
                    <input type="text"  class="form-control" id="edit-ip" name='edit-ip' placeholder="(XXX.XXX.XXX.XXX)">
                  </div>
                    <p>OVA File: <span id="edit-file-name"></span>

                    <div class="container my-3 d-flex justify-content-start" style="padding: 0px;">
                      <label for="os-select" class="mx-2">OS</label>
                      <select id="edit-os-select" class="custom-select mx-2" name="edit-os-select" style="width:25%">
                        <option value="Linux">Linux</option>
                        <option value="Windows">Windows</option>
                        <option value="FreeBSD">FreeBSD</option>
                      </select>
                      <label for="icon-picker mx-2">Icon</label>
                      <input type="text" class="form-control mx-2 icon-picker" id="edit-icon-picker" name='edit-icon-picker' placeholder="Pick one from the list or select directly" style="width:50%">
                      <button type="button" class="btn-primary mx-2 picker-button">Select</button><span class="demo-icon"></span>
                    </div>
                    <label for="description">Description</label>
                    <textarea id="edit-description" class="form-control"  name='edit-description' rows="7"></textarea>
                    <div class="my-1">
                      <h4>Flags <button type="button" class="btn btn-primary" id="collapse-flags"><i id='collapse-flags-icon' class="fas fa-compress-arrows-alt"></i></button><button type="button" class="btn btn-primary mx-1" id="new-lab-level"><i class="fas fa-plus"></i></button></h4>
                    </div>
                    <div id="level-flags" class="container">
                      <table class="table table-borderless">
                        <thead>
                          <tr>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id='level-flags-body'>

                        </tbody>
                      </table>
                    </div>
                    <div class="my-1">
                      <h4>Skills <button type="button" class="btn btn-primary" id="collapse-skills"><i id='collapse-skills-icon' class="fas fa-compress-arrows-alt"></i></button></h4>
                    </div>
                    <div id="edit-skills">
                      <table>
                        <thead>
                          <tr>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id='skills-body'>

                        </tbody>
                      </table>
                    </div>
                    <input type="submit" class="update-machine btn-primary mt-2" value="Update Machine">

                    
                </div>
              </form>

              @include('teacher.modal.icon')