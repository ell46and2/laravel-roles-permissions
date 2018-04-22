@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Show topic #1</div>

                <div class="card-body">
                    @can('edit posts')
                        <a href="#">Edit post</a>
                    @endcan

                    @role('admin')
                        <h2>User has an admin role</h2>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
