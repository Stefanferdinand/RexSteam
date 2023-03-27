<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check Age</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    @include('partials.navigation')
    <div class="bg-light p-5">
        <form action="/game/adultOnly/{{$game->id}}" method="post" class="check-age-form p-5 pb-0 d-flex flex-column justify-content-center align-items-center">
            @csrf
            <div class="check-age-content d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <img src="{{asset($game->gameCover)}}" alt="">
                </div>
                <div class="check-age-date-container p-5 pb-0">
                    <h4>CONTENT AT THIS PRODUCT MAY NOT BE APPROPRIATE FOR ALL AGES, OR MAY NOT BE APPROPRIATE FOR VIEWING AT WORK.</h4>
                    <div class="check-age-date">
                        <div class="d-flex flex-column align-items-center">
                            <h4>Please enter your birth date to continue:</h4>
                            <div class="d-flex mt-4">
                                <div class="p-1">
                                    <h5>Day</h5>
                                    <select class="date-picker pe-5 ps-2" name="day" id="day">
                                        @for($i = 0; $i < 30; $i++)
                                            <option value="{{$i+1}}">{{$i+1}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="p-1">
                                    <h5>Month</h5>
                                    <select class="date-picker pe-5 ps-2" name="month" id="month">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="p-1">
                                    <h5>Year</h5>
                                    <select class="date-picker pe-5 ps-2" name="year" id="year">
                                        @for($i = 2022; $i >= 1960; $i--)
                                            <option value={{$i}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button class="btn-check-age btn btn-dark me-2" type="submit">View Page</button>
                        <a class="btn-check-cancel btn btn-secondary ms-2 py-2" href="/game/adultOnly/-1">Cancel</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
       
    @include('partials.footer')
    
</body>
</html>