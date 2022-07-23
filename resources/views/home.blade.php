<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

</head>
<body>
<div class="container vh-100">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-lg-4 col-md-6 d-flex justify-content-center bg-primary p-5">
            <form id="user-form" class="w-100 text-center my-5">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="user_name" id="name"
                           placeholder="Enter Your Name">
                </div>
                <button type="submit" class="btn btn-secondary px-5">Next</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#user-form").submit(function(e){

        e.preventDefault();

        $.ajax({
            type:'POST',
            url:"{{ route('set.user') }}",
            data:$("#user-form").serialize(),
            success:function(response){
                if(response.success)
                    window.location.href = "{{route('test')}}"
            }
        });

    });
</script>
</body>
</html>
