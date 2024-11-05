@extends('template.master')

@section('content')

<!-- Jumbotron Section -->
<div class="jumbotron jumbotron-fluid bg-light text-center mb-4">
    <div class="container">
        <h1 class="display-4">Welcome to the {{ $setting->app_name }}</h1>
        <p class="lead">Manage your finances effectively with our comprehensive tools and features.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Menu 1</h5>
            </div>
            <div class="card-body">
                <p>Description for Menu 1. This is where you can add information related to this menu.</p>
                <a href="#" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Menu 2</h5>
            </div>
            <div class="card-body">
                <p>Description for Menu 2. This is where you can add information related to this menu.</p>
                <a href="#" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Menu 3</h5>
            </div>
            <div class="card-body">
                <p>Description for Menu 3. This is where you can add information related to this menu.</p>
                <a href="#" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Menu 1</h5>
            </div>
            <div class="card-body">
                <p>Description for Menu 1. This is where you can add information related to this menu.</p>
                <a href="#" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Menu 2</h5>
            </div>
            <div class="card-body">
                <p>Description for Menu 2. This is where you can add information related to this menu.</p>
                <a href="#" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">Menu 3</h5>
            </div>
            <div class="card-body">
                <p>Description for Menu 3. This is where you can add information related to this menu.</p>
                <a href="#" class="btn btn-primary">Continue</a>
            </div>
        </div>
    </div>
</div>

@endsection
