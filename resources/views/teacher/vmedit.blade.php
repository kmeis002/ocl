@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit a VM</div>
                @if ($errors->any())
                     <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => ['teacher.vm.update', $vm->name] ]) !!}
                        {{Form::label('VM name')}}<br>
                        {{Form::text('name')}} <br>
                        {{Form::label('Points')}}<br>
                        {{Form::number('points')}}<br>
                        {{Form::label('Operating System')}}<br>
                        {{Form::select('os', ['Linux' => 'Linux', 'Windows' => 'Windows', 'FreeBSD' => 'FreeBSD'])}}<br>
                        {{Form::label('IP Address')}}<br>
                        {{Form::text('ip')}}<br>
                        {{Form::label('Icon')}}<br>
                        {{Form::text('icon')}} <br>
                        {{Form::label('Description')}}<br>
                        {{Form::textarea('description')}}<br>
                        {{Form::submit('Submit')}}<br>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection