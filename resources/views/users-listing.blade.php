@extends('layouts.app')

@section('content')       
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <form class="d-flex" role="search" method="GET" action="{{route('users.search')}}">
                    <input class="form-control me-2" type="date"  aria-label="Date" name="date" required>
                    <input class="form-control me-2" type="search" placeholder="Search by name, email and date" aria-label="Search" name="search" required>
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                </form>
                <a href="{{route('users')}}" class="btn btn-primary">Add User</a>
            </div>
        </div>
    </nav>
    @if(isset($results))
    <div class="container d-flex flex-row">
        <p>{{$results}}</p>&nbsp;
        <a href="{{route('users.show')}}" style="text-decoration: none"> Clear Filter</a>
    </div>
    @endif
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Gender</th>
                <th scope="col">Image</th>
                <th scope="col">Created Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->gender}}</td>
                        <td>{{$user->image}}</td>
                        <td>{{$user->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
@endsection