@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, cupiditate ut totam quaerat fugit vitae ratione delectus aut, quibusdam laboriosam dolores autem explicabo quae architecto eveniet molestiae cum! Fugiat officiis exercitationem tenetur tempora tempore.
