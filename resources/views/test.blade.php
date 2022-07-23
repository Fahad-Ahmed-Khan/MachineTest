<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

</head>
<body>
<div class="container vh-100">
    <div class="text-center">
        <a class="btn btn-light text-lg" href="{{route('logout')}}">Logout</a></div>
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-lg-4 col-md-6 d-flex justify-content-center bg-primary p-3">
            <form id="question-form" class="w-100">
                @csrf
                <div class="form-group">
                    <h3 class="text-center">
                        Question: <span id="question_no"></span>
                    </h3>
                    <h5 class="question" id="question"></h5>
                    <div class="answers">
                        <input type="radio" id="ans1" name="answer" value="op1" required>
                        <label for="ans1" class="option" id="op1"></label><br>
                        <input type="radio" id="ans2" name="answer" value="op2" required>
                        <label for="ans2" class="option" id="op2"></label> <br>
                        <input type="radio" id="ans3" name="answer" value="op3" required>
                        <label for="ans3" class="option" id="op3"></label> <br>
                        <input type="radio" id="ans4" name="answer" value="op4" required>
                        <label for="ans4" class="option" id="op4"></label> <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="button" id="skip-btn" class="btn btn-secondary form-control">Skip</button>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-secondary form-control">Next</button>
                    </div>
                </div>

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

    $(document).ready(() => {
        getNextQuestion();
    });

    getNextQuestion = ()=>{
        $.ajax({
            type: 'GET',
            url: "{{ route('next.question') }}",
            success: function (response) {
                $('#question_no').text(response.question_no);
                $('#question').text(response.question);
                $('#op1').text(response.op1);
                $('#op2').text(response.op2);
                $('#op3').text(response.op3);
                $('#op4').text(response.op4);
            }
        });
    }

    function checkResponse(response) {
        if (response.success) {
            if (!response.is_ended){
                $('#question-form').trigger("reset");;
                getNextQuestion();
            }
            else {
                window.location.href = "{{route('results')}}"
            }
        }
    }

    $('#question-form').submit((e)=>{
        e.preventDefault();

        $.ajax({
            type:'POST',
            url:"{{ route('submit.answer') }}",
            data:$("#question-form").serialize(),
            success:function(response){
                checkResponse(response);
            }
        });
    });

    $('#skip-btn').on("click",(e)=>{
        e.preventDefault();

        $.ajax({
            type:'POST',
            url:"{{ route('skip.question') }}",
            data:$("#question-form").serialize(),
            success:function(response){
                if(response.success){
                    checkResponse(response);
                }
            }
        });
    });
</script>
</body>
</html>
