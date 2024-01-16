@extends('layouts.app')

@section('content')

        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                    <form class="d-flex" role="search" id="search_form" method="get" action="javascript:void(0)">
                        @csrf
                        <select class="form-select me-2" aria-label="Gender" id="gender" onchange="print1()">
                            <option value="">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <input class="form-control me-2" type="date"  aria-label="Date" onchange="print1()" name="date" id="date">
                        <input class="form-control me-2" type="search" placeholder="Search by name & email" aria-label="Search" name="search" onKeyup="print1()" id="search">
                        <a class="btn btn-success me-2" onclick="export_data()">Export</a>
                        
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
                        <th scope="col">Action</th>
                        <th scope="col">Owner</th>
                    </tr>
                </thead>
                <tbody id="my-table">
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
    <script>
       $( document ).ready(function() {
        print1();
        print2();
        });
        function print1(query = ''){
            var search = $('#search').val();
            var date = $('#date').val();
            var gender = $('#gender').val();
            // alert(date);
            // alert(gender);
            $.ajax({
                url: "{{ route('users.ajshow') }}",
                type: "GET",
                dataType:"JSON",
                data: {
                    _token:"{{csrf_token()}}",
                    search : search,
                    date: date,
                    gender:gender
                },
                success: function(response) {
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
                                <a href="http://laravel-app.test/users/${item.id}/edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>${item.owner}</td>
                        </tr>`;
                    });
                    $("#my-table").html($tr);
                }
            });
        }
        function export_data(){
            var search = $('#search').val();
            var date = $('#date').val();
            var gender = $('#gender').val();
            // console.log(search,date,gender);
            // alert(date);
            // alert(gender);
            $.ajax({
                url: "{{ route('users.export') }}",
                type: "GET",
                dataType:"JSON",
                data: {
                    search : search,
                    date: date,
                    gender:gender
                },  
                success: function (response) {
                    var a = document.createElement("a");
                    a.href = response.file; 
                    a.download = response.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    $("#downloadExcel").show();
                    $("#ExcelDownloadLoader").hide();
                },
                error: function (ajaxContext) {
                    $("#downloadExcel").show();
                    $("#ExcelDownloadLoader").hide();
                    alert('Export error: '+ajaxContext.responseText);
                }
            });            
        }
        function print2(){
        
        $.ajax({
            url: "{{ route('admin.show3') }}",
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
                            <td></td>
                            <td>${item.owner}</td>
                        </tr>`;
                    });
                    $("#my-table").append($tr);
            }
        });
        
    }
    </script>          
@endsection
