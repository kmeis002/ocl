<div class="container">
    <div class='container-fluid lab-layout bg-primary-trans my-3 py-2'>
        <div class="row"> 
            <div class="vm-info">
                    <div class="row">
                        <div class="icon">
                            <i class=" fa-7x" id="vm-icon"></i>
                        </div>
                        <div class="col-lg-7">
                            <div class="vm-prop">
                                 <p>Lab Name: <span id='vm-name'></span></p>
                            </div>
                            <div class="vm-prop">
                                 <p>Points: <span id='vm-points'></span></p>
                            </div>
                            <div class="vm-prop">
                                 <p>OS: <span id='vm-os'></span></p>
                            </div>
                            <div class="vm-prop">
                                 IP: <span id='vm-ip'></span>
                            </div>
                        </div>
                    </div>
                    <div class="skills my-1">
                        <p class=" my-auto">Skills: <span id='vm-skills'></span> </p>
                    </div>
            </div>
            <div class="student-info align-items-center">
                    <div class="status">
                        <p class="text-center  my-auto">Status: </p>
                        <i class="fas fa-power-off fa-2x my-auto mx-2 text-primary" id='vm-status-icon'></i>
                   </div>
                    <div class="student-progress">
                        <div class="progress my-auto" style="width:100%;">
                            <div class="progress-bar progress-bar-striped  bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row my-3">
                    <p class="mx-1">Description:</p>
                    <div class="lab-description mx-1">
                        <p class="mx-1"> <span id='vm-description'></span></p>
                    </div>
                </div>
                <div class="row my-3">
                    <p class="mx-1">Messages:</p>
                    <div class="lab-description mx-1" id="ajax-alert">
                        <p class="mx-1"> </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Hints</th>
                                <th>Submit Flag</th>
                            </tr>
                        </thead>
                        <tbody id="lab-table-body">

                        </tbody>
                    </table>
            </div>
        </div>
    </div>