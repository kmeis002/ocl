@extends('layouts.app')

<input type="hidden" class="api_token" value="{{ Auth::user()->api_token }}"> </div>

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
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

                    Create a VM!
                    {!! Form::open(['route' => 'teacher.vm.store', 'files'=>'true']) !!}
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
                        {{Form::label('OVA upload')}}<br>
                        {{Form::file('ova', ['onchange' => 'window.selectorScript("http://www.ocl.dev/api/chunk_upload")', 'class' => 'ova'])}} <p id="percent"></p>
                        {{Form::submit('Submit', ['id'=>'submit'])}}<br>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



