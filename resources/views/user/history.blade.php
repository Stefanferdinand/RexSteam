<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>History</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    @include('partials.navigation')
    <div class="bg-light p-5 full">
        <div class="d-flex bg-white border border-dark mt-5">
            <div class="col-3 d-flex flex-column border-end pe-5 py-5 text-decoration-none">
                {{-- profile --}}
                <div class="ps-4 mb-5">
                    <a class="text-decoration-none text-dark" href="/user/profile">
                        <h4>Profile</h4>
                    </a>
                </div>
                @if($user->roleId == 2)
                    {{-- friends --}}
                    <div class="ps-4 mb-5">
                        <a class="text-decoration-none text-dark" href="/user/friend">
                            <h4>Friends</h4>
                        </a>
                    </div>
                    {{-- transaction history --}}
                    <div class="border-start border-5 border-primary ps-4 mb-5">
                        <h4>Transaction History</h4>
                    </div>
                @endif
            </div>


            <div class="col py-5 px-5 pb-3">
                <div>
                    <h2>Transaction History</h2>
                </div>
                @foreach ($transaction as $item)
                    <p>Transaction ID: {{$item->id}}</p>
                    <p>Purchase Date: {{$item->purchaseDate}}</p>  
                    <div class="row d-flex flex-wrap"> 
                        @foreach ($games[$item->id] as $game)
                            <img width="05" height="150" class="col-4 mb-3" src="{{$game->gameCover}}" alt="">
                        @endforeach           
                    </div>
                    <div class="col d-flex mt-3 align-items-center">
                        <p class="m-0">Total Price: </p>
                        <h5 class="ms-3">Rp.{{number_format($item->totalPrice)}}</h5>
                    </div>
                    <hr>
                @endforeach
            </div>

        </div>
    </div>
    @include('partials.footer')

</body>
</html>