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
            <td class="icon"><span class="text-center"><i class="{{$item->icon}} my-2"></i></span></td>
            <td class="machine-name"><button type="button" class="btn btn-primary update-model-view" data-name="{{$item->name}}">{{$item->name}}</button></td>
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
            @if(in_array($item->name, $completed))
            <td><button type='button' class="btn btn-primary" disabled="true" data-toggle="modal" data-target="#flagModal" data-title="{{$item->name}}"><i class="fas fa-flag fa-2x"></i></button></td>
            @else
            <td><button type='button' class="btn btn-secondary" data-toggle="modal" data-target="#flagModal" data-title="{{$item->name}}"><i class="fas fa-flag fa-2x"></i></button></td>
            @endif
          </tr></a>
          @endforeach
        </tbody>
      </table>
     </div>
     @endif

@section('modals')
@include('student.modal.flag')
@include('student.modal.hint')
@if($type==='ctf')
@include('student.modal.description')
@endif
@endsection