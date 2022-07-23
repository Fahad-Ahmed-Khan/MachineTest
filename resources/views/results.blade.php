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
        <div class="col-lg-4 col-md justify-content-center bg-primary p-5">
            <h4 class="h4 text-center">Result Page</h4> <br />
            <table class="table table-lg">
                <tr>
                    <td>Correct Answers</td><td>{{$result->correct}}</td>
                </tr>

                <tr>
                    <td>Wrong Answers</td><td>{{$result->wrong}}</td>
                </tr>

                <tr>
                    <td>Skipped Answers</td><td>{{$result->skipped}}</td>
                </tr>
            </table>
            <a class="btn btn-light pull-right" href="{{route('logout')}}">Logout</a>
            <a class="btn btn-warning" href="{{route('test')}}">Try Again</a>
        </div>
    </div>
</div>
</body>
</html>
