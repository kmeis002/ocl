@extends('layouts.student')

@section('modal-scripts')
        <script src={{ asset('js/b2r-scripts.js') }}></script>
@endsection


@section('nav')
@include('student.nav.nav')
@endsection

@section('content')

<div class="container">
    <div class='container-fluid lab-layout bg-primary-trans my-3 py-2'>
        <div class="row"> 
            <div class="vm-info">
                    <div class="row">
                        <div class="icon">
                            <i class="{{$vm->icon}} fa-7x"></i>
                        </div>
                        <div class="col-lg-7">
                            <div class="vm-prop">
                                 <p>Boot2Root Name: <span id='vm-name'>{{$vm->name}}</span></p>
                            </div>
                            <div class="vm-prop">
                                 <p>Points: {{$vm->points}}</p>
                            </div>
                            <div class="vm-prop">
                                 <p>OS: {{$vm->os}}</p>
                            </div>
                            <div class="vm-prop">
                                 IP: {{$vm->ip}}
                            </div>
                        </div>
                    </div>
                    <div class="skills my-1">
                        <p class=" my-auto">Skills: @foreach( $skills as $skill ) {{$skill->skill}} - @endforeach </p>
                    </div>
            </div>
            <div class="student-info align-items-center">
                    <div class="status d-flex justify-content-center">
                        <p class="text-center  my-auto">Status: </p>
                        @if($vm->status) <i class="fas fa-power-off fa-2x my-auto mx-2 text-primary" id='status-icon'></i>
                        @else <i class="fas fa-power-off fa-2x my-auto mx-2 text-danger" id='status-icon'></i>
                        @endif
                    </div>
                    <div class="student-progress">
                            <div class="col-md-6 user-flag">
                                <p class='text-center'>User Flag</p>
                                <div class="text-center" id='user-flag'><button type="button" class="btn btn-danger" id="user-flag" data-toggle="modal" data-target="#flagModal" data-title="Submit User Flag"><i class="fas fa-flag fa-3x"></i></button></i></div>
                            </div>
                            <div class="col-md-6 user-flag">
                                <p class='text-center'>Root Flag</p>
                                <div class="text-center" id='user-flag'><button type="button" class="btn btn-danger" id="root-flag" data-toggle="modal" data-target="#flagModal" data-title="Submit Root Flag"><i class="fas fa-flag fa-3x"></i></button></i></div>
                            </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row my-3">
                    <p class="mx-1">Description:</p>
                    <div class="lab-description mx-1">
                        <p class="mx-1"> {{$vm->description}} </p>
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
                        @foreach($user_hints as $hint)
                        <div>
                         <button type="button" class="btn btn-primary-trans my-2" id="user-hint-{{ $loop->index }}" data-toggle="modal" data-target="#hintModal" data-hintnum="{{ $loop->index }}" data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal User Hint #{{ $loop->index + 1 }}" data-isroot="false">Hint #{{$loop->index + 1}}</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-lg-3 hints text-center">
                        <p>Root Hints</p>
                        @foreach($root_hints as $hint)
                        <div>
                          <button type="button" class="btn btn-primary-trans my-2" id="root-hint-{{ $loop->index }}" data-toggle="modal" data-target="#hintModal" data-hintnum="{{ $loop->index }}" data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal Root Hint #{{ $loop->index + 1 }}" data-isroot="true">Hint #{{$loop->index + 1}}</button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='container-fluid lab-layout  bg-primary-trans  my-5'>
        Related Guides & Lessons!
    </div>
</div>
@endsection




@section('modals')
    @include('student.modal.hint')
    @include('student.modal.flag')
@endsection