@extends('layouts.app')

@section('content')       
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Request by</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)    
                <tr>
                    <td scope="row">{{ $loop->index+1 }}</td>
                    <td>{{$request->mapped_owner}}</td>
                    <td>{{$request->created_at}}</td>
                    @if($request->is_approved == 0)
                        <td>Pending</td>
                    @else
                        <td>Approved</td>
                    @endif
                    @if($request->owner == Auth::user()->name and $request->is_approved==0)
                        <td><a href="http://laravel-app.test/request/{{$request->id}}/approve">Approve</a></td>
                    @else
                        <td>------</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
@endsection