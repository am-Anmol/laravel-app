@extends('layouts.app')

@section('content')
<div class="container">
    <form id="user_form" method="post" action="javascript:void(0)">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select me-2" aria-label="Gender" id="gender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary" id="user_form_button">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>     
<script>
    $('#user_form_button').click(function(e){
        e.preventDefault();
        let form = $('#user_form')[0];
        let data = new FormData(form);

        $.ajax({
        url: "{{ route('users.store') }}",
        type: "POST",
        data : data,
        dataType:"JSON",
        processData : false,
        contentType:false,
        
        success: function(response) {

        if (response.errors) {
            var errorMsg = '';
            $.each(response.errors, function(field, errors) {
                $.each(errors, function(index, error) {
                    errorMsg += error + '<br>';
                });
            });
            iziToast.error({
                message: errorMsg,
                position: 'topRight'
            });
            
        } else {
            iziToast.success({
            message: response.success,
            position: 'topRight'
            
                    });
            window.location = "{{ route('users.show') }}";
        }
                    
        },
        error: function(xhr, status, error) {
            
            iziToast.error({
                message: 'An error occurred: ' + error,
                position: 'topRight'
            });
        }
    });

    });
</script>        
@endsection