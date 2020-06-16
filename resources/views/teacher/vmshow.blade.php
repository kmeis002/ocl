@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$vm->name}}</div>
                <div><p>OS: {{$vm->os}}</p></div>
                <div><p>Description: {{$vm->description}}</p></div>
                <div><p>Points: {{$vm->points}}</p></div>
                <div><p>OVA Location: {{env('VM_FILE_LOCATION')}}{{$vm->file}}</p></div>
                <div><p>IP:{{$vm->ip}}</p></div>
                <div><small>{{$vm->created_at}}</small></div>
                <div><small>{{$vm->updated_at}}</small></div>
                <div><a href='/teacher/vm/{{$vm->name}}/edit' class='btn btn-default'>Edit</a></div>
                <div>
                     {!! Form::open(['route' => ['teacher.vm.destroy', $vm->name ] ]) !!}
                     {{ Form::submit('delete', ['class' => 'btn btn-default']) }}
                     {!! Form::close() !!}
                </div>
                <div class="card-body">
                </div>

                    
            </div>
        </div>
    </div>
</div>
@endsection
