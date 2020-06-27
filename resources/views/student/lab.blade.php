@extends('layouts.student')

@section('modal-scripts')
        <script src={{ asset('js/lab-scripts.js') }}></script>
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
                                 <p>Lab Name: <span id='vm-name'>{{$vm->name}}</span></p>
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
                    <div class="status">
                        <p class="text-center  my-auto">Status: </p>
                        @if($vm->status) <i class="fas fa-power-off fa-2x my-auto mx-2 text-primary" id='status-icon'></i>
                        @else <i class="fas fa-power-off fa-2x my-auto mx-2 text-danger" id='status-icon'></i>
                        @endif
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
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Hints</th>
                                <th>Submit Flag</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1; $i <= $lvls; $i++)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            @foreach($hints as $hint)
                                                @if($hint->level == $i)
                                            <button type="button" class="btn btn-primary-trans" id="test" data-toggle="modal" data-target="#hintModal" data-hintnum="{{$loop->index}}" data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal Hint #{{$loop->index + 1}} for {{$vm->name}}  Level  {{$i}}?">Hint #{{$loop->index + 1}}</button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#flagModal"><i class="{{ $vm->icon }}"></i></button></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
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