@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">VM Indexing Test</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($vms) > 0)
                        @foreach($vms as $vm)
                            <div class="well">
                                <p><a href="/teacher/vm/show/{{$vm->name}}">Name: {{{$vm->name}}}1  </a> | OS: {{$vm->os}} | Points: {{$vm->points}}</p>
                                <small>@ IP address: {{$vm->ip}}</small>
                            </div>
                        @endforeach
                    @else
                        <p>No VMs loaded</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
