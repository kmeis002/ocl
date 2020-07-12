@extends('layouts.student')

@section('scripts')
@if($type !== 'ctf')
<script src={{ asset('js/studentmachinelist.js') }}></script>
  @if($type === 'b2r')
  <script src={{ asset('js/studentb2rs.js') }}></script>
  @elseif($type === 'lab')
  <script src={{ asset('js/studentlabs.js') }}></script>
  @endif
@endif
@if($type === 'ctf')
<script src={{ asset('js/studentctflist.js') }}></script>
@endif
@endsection

@section('nav')
@include('student.nav.nav')
@endsection


@section('content')

<div class="container justify-content-center my-5">
  <h1 class="text-center">List of {{$type}}s</h1>
</div>

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

@if($type !== 'ctf')
  <div class="container d-flex justify-content-between model-view my-5">
@else
 <div class="container d-flex justify-content-between my-5">
@endif
    <div class="row">
      <div class="col-lg">
        @include('student.resources.tables.tablelist')
      </div>
@if($type !== 'ctf')
      <div class="col-lg">
        @if($type === 'b2r')
        @include('student.resources.forms.displayb2r')
        @elseif($type === 'lab')
        @include('student.resources.forms.displaylab')
        @endif
      </div>
@endif
    </div>
  </div>
</div>
@endsection



@section('modals')
@if($type === 'ctf')
@include('student.modal.description')
@endif
@include('student.modal.flag')
@endsection