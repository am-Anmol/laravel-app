@extends('layouts.app')

@section('content')
<div class="container">
    <form method="post" action="{{ route('users.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Upload Excel</label>
            <input type="file" class="form-control" id="file" name="file">
            <a href="/documents/import_users_sample.xlsx" download>Sample Excel</a>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
@endsection