@extends('layouts.app')

@section('content')       
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
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id='my-table'>
                
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
<script>
    $( document ).ready(function() {
    print1();
    });
    function print1(){
        
        $.ajax({
            url: "{{ route('admin.show2') }}",
            type: "GET",
            dataType:"JSON",
            
            success: function(response) {
                console.log(response);
                var $tr =``;
                    $.each(response, function(i, item) {
                     $tr += `
                        <tr>
                            <td>${i+1}</td>
                            <td>${item.name}</td>
                            <td>${item.email}</td>
                            <td>${item.gender}</td>
                            <td><img src="${item.image}" width="100" height="100"></td>
                            <td>${item.created_at}</td>
                            <td>
                                <a href="http://laravel-app.test/request/${item.id}/send">Request</a>
                            </td>
                        </tr>`;
                    });
                    $("#my-table").html($tr);
            }
        });
        
    }
</script>          
@endsection