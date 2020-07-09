@extends('layouts.teacher')

@section('scripts')

@if($type === 'b2r')
  <script src="{{ asset('js/teacherb2r.js') }}"></script>
@elseif($type === 'lab')
<script src="{{ asset('js/teacherlab.js') }}"></script>
@endif
@if(Session::has('updated'))
  <script>
    $(document).ready(function(){
      getModelInfo('{{$type}}','{{Session::get('updated')}}');
    });
  </script>
@endif

@endsection

@section('content')
<div class="container justify-content-center my-5">
  <h1 class="text-center" id="type-header" data-model-type="{{$type}}">List of {{$type}}s</h1>
</div>

@include('teacher.errors.validationerrors')

<div class="container  d-flex my-3 justify-content-center text-center">
	<label for="name-search my-3">Search by name: </label><input class="search mx-1" type="text" id='name-search' label="Search by name:">
</div>

<div class="container  d-flex my-3 justify-content-center">
@if($type !== 'ctf')
  <div class="btn-group btn-group-toggle mx-2" data-toggle="buttons">
  <label class="btn btn-secondary active">
    <input type="radio" name="os-options" id="os-option1"  value="All" autocomplete="off" checked> All
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="os-options" id="os-option2" value="Windows" autocomplete="off"> Windows
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="os-options" id="os-option3" value="Linux" autocomplete="off"> Linux
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="os-options" id="os-option4" value="FreeBSD" autocomplete="off"> FreeBSD
  </label>
</div>
@endif

@if($type === 'ctf')
  <div class="btn-group btn-group-toggle mx-5" data-toggle="buttons">
      <label class="btn btn-secondary active">
        <input type="radio" name="cat-options" id="os-option1"  value="All" autocomplete="off" checked> All
      </label>
    @foreach($categories as $cat)
      <label class="btn btn-secondary active">
        <input type="radio" name="cat-options" id="os-option1"  value="{{$cat->category}}" autocomplete="off"> {{$cat->category}}
      </label>
    @endforeach
  </div>
@endif

  <div class="btn-group btn-group-toggle mx-5" data-toggle="buttons">
  <label class="btn btn-secondary active">
    <input type="radio" name="s-options" id="s-option1" value="All" autocomplete="off" checked> All
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="s-options" id="s-option2" value="Assigned" autocomplete="off"> Assigned
  </label>
  <label class="btn btn-secondary">
    <input type="radio" name="s-options" id="s-option3" value="Incomplete" autocomplete="off"> Incomplete
  </label>
</div>

  <div class="btn-group btn-group-toggle mx-5" data-toggle="buttons">
  <label class="btn btn-secondary active">
    <input type="radio" name="pt-options" id="pt-option1" value="All" autocomplete="off" checked> All
  </label>
  @for($i=10; $i<=100; $i=$i+10)
  <label class="btn btn-secondary">
    <input type="radio" name="pt-options" id="pt-option2" value="{{$i}}" autocomplete="off"> {{$i}}
  </label>
  @endfor
</div>
</div>


<div class="container d-flex justify-content-center list-view-container">
  <div class="row">
   <div class='col container d-flex flex-row my-3 justify-content-start machine-list' style="flex-wrap: wrap">
    <table class="table table-dark table-borderless table-striped table-hover">
      <thead>
        <tr>
          <th class= "icon" scope="col"> </th>
          <th scope="col" class="my-auto">Name</th>
          <th scope="col" class="text-right option-cluster"> New <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create{{$type}}Modal"><i class="fas fa-plus"></i></button></th>
        </tr>
      </thead>
      <tbody id="machine-list">
        @foreach($list as $item)
        <tr>
          <td class="icon"><span class="text-center"><i class="{{$item->icon}}"></i></span></td>
          <td class="machine-name">{{$item->name}}</td>
          <td class="option-cluster text-right" >
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <button type="button" class="edit-{{$type}} btn btn-primary" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="Edit Machine"><i class="fas fa-pen"></i></button>
                <button type="button" class="edit-hints btn btn-primary edit-hints-modal" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="Edit Hints"><i class="fas fa-puzzle-piece"></i></button>
                @if(isset($item->file))
                <button type="button" class="rotate-flags btn btn-primary" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="Sync Flags"><i class="fas fa-sync"></i></button>     
                @if($item->status === 0)
                <button type="button" class="power-off btn btn-danger vmmanage-modal" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="Manage Virtual Machine"><i class="fas fa-cube"></i></button>
                @else
                <button type="button" class="power-off btn btn-primary vmmanage-modal" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="Manage Virtual Machine"><i class="fas fa-cube"></i></button>
                @endif
                @else
                <button type="button" class="upload-ova btn btn-primary" data-name="{{$item->name}}" data-toggle="modal" data-target="#uploadOvaModal" data-toggle="tooltip" data-placement="top" title="Upload Virtual Machine"><i class="fas fa-upload"></i></button>
                @endif
                <button type="button" class="delete btn btn-primary" data-name="{{$item->name}}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></button>
            </div>
          </td>
        </tr></a>
        @endforeach
      </tbody>
    </table>
   </div>

   <div class="col container info-window">
          <div class='container-fluid lab-layout bg-primary-trans my-3 py-2'>
            @if($type === 'b2r')
              @include('teacher.forms.editB2R')
            @elseif($type === 'lab')
              @include('teacher.forms.editLab')
            @endif
            </div>
          </div>
        </div>
    </div>
   </div>
  </div>
</div>

@endsection

@section('modals')
@if($type === 'b2r')
@include('teacher.modal.createB2RForm')
@endif
@if($type === 'lab')
@include('teacher.modal.createLabForm')
@endif
@include('teacher.modal.editHints')
@include('teacher.modal.uploadOva')
@include('teacher.modal.vmManage')
@endsection

