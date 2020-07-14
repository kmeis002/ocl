<div class="container">
    <div class='container-fluid lab-layout bg-primary-trans my-3 py-2'>
        <div class="row"> 
            <div class="vm-info">
                    <div class="row">
                        <div class="icon">
                            <i class=" fa-7x" id='vm-icon'></i>
                        </div>
                        <div class="col-lg-7">
                            <div class="vm-prop">
                                 <p>Boot2Root Name: <span id='vm-name'></span></p>
                            </div>
                            <div class="vm-prop">
                                 <p>Points: <span id='vm-points'></span></p>
                            </div>
                            <div class="vm-prop">
                                 <p>OS: <span id='vm-os'></span></p>
                            </div>
                            <div class="vm-prop">
                                 IP: <span id='vm-ip' class="mx-1"></span>
                            </div>
                        </div>
                    </div>
                    <div class="skills my-1">
                        <p class=" my-auto">Skills: <span id='vm-skills'></span></p>
                    </div>
            </div>
            <div class="student-info align-items-center">
                    <div class="status d-flex justify-content-center">
                        <p class="text-center  my-auto">Status: </p>
                        <i class="fas fa-power-off fa-2x my-auto mx-2 text-primary" id='vm-status-icon'></i>
                    </div>
                    <div class="student-progress">
                            <div class="col-md-6 user-flag">
                                <p class='text-center'>User Flag</p>
                                <div class="text-center" ><button type="button" class="btn btn-danger" id="user-flag" data-toggle="modal" data-target="#flagModal" data-title="Submit User Flag" data-flag="user"><i class="fas fa-flag fa-3x"></i></button></i></div>
                            </div>
                            <div class="col-md-6 user-flag">
                                <p class='text-center'>Root Flag</p>
                                <div class="text-center" ><button type="button" class="btn btn-danger" id="root-flag" data-toggle="modal" data-target="#flagModal" data-title="Submit Root Flag" data-flag="root"><i class="fas fa-flag fa-3x"></i></button></i></div>
                            </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row my-3">
                    <p class="mx-1">Description:</p>
                    <div class="lab-description mx-1">
                        <p class="mx-1" id="vm-description"> DESCRIPTION HERE</p>
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
                <div class="row my-3">
                    <div class="col-lg-3 hints text-center">
                        <p>User Hints</p>
                        <div id="user-hints">

                        </div>
                    </div>
                    <div class="col-lg-3 hints text-center">
                        <p>Root Hints</p>
                        <div id="root-hints">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>