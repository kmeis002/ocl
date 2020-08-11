@if(count($errors) > 0)
  <div class="alert alert-danger-trans text-left d-flex justify-content-center">
    <strong>Errors Found!</strong> 
    <br><br>
    <ul>
      @foreach($errors->all() as $e)
        <li>{{$e}}</li>
      @endforeach
    </ul>
  </div>
@endif