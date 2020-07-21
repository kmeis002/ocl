              <form id="new-lab" action="/teacher/create/ctf" method="POST">
                @csrf
                <div class="form-group">
                  <label for="ctf-name">CTF Name</label>
                  <input id="ctf-name" name="ctf-name" type="text" class = "form-control" placeholder="Your machine name MUST be the same as your zip file name. (<name>.zip)">
                  <div class="container my-3 d-flex justify-content-between" style="padding: 0px;">
                    <label for="pts" class="my-1 mx-2">Points</label>
                    <input type="text"  class="form-control non-file" id="new-pts" name="pts" placeholder="(0-100)">
                    <label for="category" class="my-1 mx-2">Category</label>
                    <input type="text"  class="form-control non-file" id="category" name="category">
                  </div>
                  <div class="container d-flex justify-content-between">
                      <label for="icon-picker mx-2">Icon</label>
                      <input type="text" class="form-control mx-2 icon-picker non-file" id="icon-picker" name="icon" placeholder="Pick one from the list or select directly" style="width:50%">
                      <button type="button" class="btn-primary mx-2 picker-button">Select</button><span class="demo-icon"></span>
                    </div>
                    <label for="description" class="my-2">Description</label>
                    <textarea id="description" name="description" class="form-control non-file" rows="7"></textarea>

                    <label for="flag" class="my-2">Flag</label>
                    <input class="form-control" id="flag" name="flag">
                    <input type="Submit" class="btn-primary mt-2" value="Add Machine">
                </div>
              </form>