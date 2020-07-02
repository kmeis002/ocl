@extends('layouts.student')

@section('scripts')
<script src={{ asset('js/list-scripts.js') }}></script>
@endsection

@section('nav')
@include('student.nav.nav')
@endsection


@section('content')

<div class="d-flex justify-content-center">
  <button id='all'>All</button>
  <button id='btn-animal'>animal</button>
  <button id='btn-city'>city</button>
  <button id='btn-nature'>nature</button>
</div>
<div class="row my-shuffle-container justify-content-center">
  <div class="col-2 picture-item column" data-groups='["animal"]' data-date-created="2016-08-12" data-title="Crocodile">
    <div class="aspect">
      <div class="aspect__inner">
        <div>
            <a href="/presenter/">
                <div class="card img bg-primary-trans overlay" id="test" style="width: 15rem; height: 18rem;">
                     <div class="card-header bg-primary-trans">
                      <p class="text-center my-1">Name Goes Here</p>
                     </div>
                     <div class="card-body">
                         <i class="fas fa-stop fa-3x card-img-top text-center my-4"></i>
                      </div>
                      <div class="card-footer bg-primary-trans">
                        <p class="text-center my-1">OS:b</p>
                        <p class="text-center my-1">Points:a</p>
                      </div>
              </div>
            </a>
          </div>
      </div>
    </div>
  </div>
  <div class="col-2 picture-item column" data-groups='["city"]' data-date-created="2016-06-09" data-title="Crossroads">
    <div class="aspect">
      <div class="aspect__inner">
            <a href="/presenter/">
                <div class="card img bg-primary-trans overlay" id="test" style="width: 15rem; height: 18rem;">
                     <div class="card-header bg-primary-trans">
                      <p class="text-center my-1">Name Goes Here</p>
                     </div>
                     <div class="card-body">
                         <i class="fas fa-stop fa-3x card-img-top text-center my-4"></i>
                      </div>
                      <div class="card-footer bg-primary-trans">
                        <p class="text-center my-1">OS:b</p>
                        <p class="text-center my-1">Points:a</p>
                      </div>
              </div>
            </a>
      </div>
    </div>
  </div>
  <div class="col-2 picture-item column" data-groups='["nature"]' data-date-created="2015-10-20" data-title="Central Park">
    <div class="aspect">
      <div class="aspect__inner">
            <a href="/presenter/">
                <div class="card img bg-primary-trans overlay" id="test" style="width: 15rem; height: 18rem;">
                     <div class="card-header bg-primary-trans">
                      <p class="text-center my-1">Name Goes Here</p>
                     </div>
                     <div class="card-body">
                         <i class="fas fa-stop fa-3x card-img-top text-center my-4"></i>
                      </div>
                      <div class="card-footer bg-primary-trans">
                        <p class="text-center my-1">OS:b</p>
                        <p class="text-center my-1">Points:a</p>
                      </div>
              </div>
            </a>
      </div>
    </div>
  </div>
   <div class="col-2 picture-item column" data-groups='["animal"]' data-date-created="2016-08-12" data-title="Crocodile">
    <div class="aspect">
      <div class="aspect__inner">
            <a href="/presenter/">
                <div class="card  img bg-primary-trans overlay" id="test" style="width: 15rem; height: 18rem;">
                     <div class="card-header bg-primary-trans">
                      <p class="text-center my-1">Name Goes Here</p>
                     </div>
                     <div class="card-body">
                         <i class="fas fa-stop fa-3x card-img-top text-center my-4"></i>
                      </div>
                      <div class="card-footer bg-primary-trans">
                        <p class="text-center my-1">OS:b</p>
                        <p class="text-center my-1">Points:a</p>
                      </div>
              </div>
            </a>
      </div>
    </div>
  </div>
   <div class="col-2 picture-item column" data-groups='["nature"]' data-date-created="2015-10-20" data-title="Central Park">
    <div class="aspect">
      <div class="aspect__inner">
            <a href="/presenter/">
                <div class="card img bg-primary-trans overlay" id="test" style="width: 15rem; height: 18rem;">
                     <div class="card-header bg-primary-trans">
                      <p class="text-center my-1">Name Goes Here</p>
                     </div>
                     <div class="card-body">
                         <i class="fas fa-stop fa-3x card-img-top text-center my-4"></i>
                      </div>
                      <div class="card-footer bg-primary-trans">
                        <p class="text-center my-1">OS:b</p>
                        <p class="text-center my-1">Points:a</p>
                      </div>
              </div>
            </a>
      </div>
    </div>
  </div>
  <div class="col-1 my-sizer-element"></div>
</div>

@endsection



<!--
            <a href="/presenter/">
                <div class="card bg-primary-trans overlay" id="test" style="width: 15rem; height: 18rem;">
                     <div class="card-header bg-primary-trans">
                      <p class="text-center my-1">Name Goes Here</p>
                     </div>
                     <div class="card-body">
                         <i class="fas fa-stop fa-3x card-img-top text-center my-4"></i>
                      </div>
                      <div class="card-footer bg-primary-trans">
                        <p class="text-center my-1">OS:b</p>
                        <p class="text-center my-1">Points:a</p>
                      </div>
              </div>
            </a>

-->