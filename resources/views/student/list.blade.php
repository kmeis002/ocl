@extends('layouts.student')

@section('scripts')
@if($type !== 'ctf')
<script src={{ asset('js/machine-list-scripts.js') }}></script>
@endif
@if($type === 'ctf')
<script src={{ asset('js/ctf-list-scripts.js') }}></script>
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


@if($type === 'lab' || $type === 'b2r')
 <div class='container d-flex flex-row my-3 justify-content-start machine-list' style="max-width: 1500px; flex-wrap: wrap">
  <table class="table table-dark table-borderless table-striped table-hover">
    <thead>
      <tr>
        <th class= "icon" cope="col"> </th>
        <th scope="col">Machine Name</th>
        <th scope="col">OS</th>
        <th scope="col">Points</th>
        <th scope="col">Assigned</th>
      </tr>
    </thead>
    <tbody id="machine-list">
      @foreach($list as $item)
      <tr>
        <td class="icon"><span class="text-center"><i class="{{$item->icon}}"></i></span></td>
        <td class="machine-name"><a href="/presenter/{{$type}}/{{$item->name}}">{{$item->name}}</a></td>
        <td class="os" >{{$item->os}}</td>
        <td class="pts">{{$item->points}}</td>
        <td>To Be Implemented</td>
      </tr></a>
      @endforeach
    </tbody>
  </table>
 </div>
 @endif

 @if($type === 'ctf')
 <div class='container d-flex flex-row my-3 justify-content-start ctf-list' style="max-width: 1500px; flex-wrap: wrap">
  <table class="table table-dark table-borderless table-striped table-hover">
    <thead>
      <tr>
        <th class= "icon" cope="col"> </th>
        <th scope="col">CTF Name</th>
        <th scope="col">Category</th>
        <th scope="col">Points</th>
        <th scope="col">Description</th>
        <th scope="col">Assigned</th>
        <th scope="col">Submit Flag</th>
      </tr>
    </thead>
    <tbody id="ctf-list">
      @foreach($list as $item)
      <tr>
        <td class="icon"><span class="text-center"><i class="{{$item->icon}}"></i></span></td>
        <td class="ctf-name"><a href="#">{{$item->name}}</a></td>
        <td class="cat">{{$item->category}}</td>
        <td class="pts">{{$item->points}}</td>
        <td class="description" ><button type="button" class="btn-primary" data-toggle="modal" data-target="#descriptionModal" data-title="{{$item->name}} Description" data-msg="{{$item->description}}"><i class="fas fa-question fa-2x"></i></button></td>
        <td class="assigned">filler</td>
        <td><button type='button' class="btn-secondary" data-toggle="modal" data-target="#flagModal" data-title="{{$item->name}}"><i class="fas fa-flag fa-2x"></i></button></td>
      </tr></a>
      @endforeach
    </tbody>
  </table>
 </div>
 @endif

@endsection



@section('modals')
@include('student.modal.description')
@include('student.modal.flag')
@endsection