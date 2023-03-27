<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$game->gameName}}</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    {{-- error handling --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show fixed-top m-5" role="alert">
            <ul>
                {{$errors->first()}}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- status --}}
    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show fixed-top m-5" role="alert">
            {{Session::get('status')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @include('partials.navigation')
    <div class="bg-light p-5">
        <div class="d-flex align-items-center mb-5 text-secondary">
            <img class="game-home-icon me-4" src="{{asset('images/home-icon.png')}}" alt="">
            <span class="me-4">></span>
            <h4 class="m-0 me-4">{{$game->genreId}}</h4>
            <span class="me-4">></span>
            <h4 class="m-0 me-4">{{$game->gameName}}</h4>
        </div>
        
        <div class="d-flex row">
            <div class="col-8">
                <video class="w-100" controls>
                    <source src="{{asset($game->gameTrailer)}}" type="video/webm">
                </video>
            </div>
            <div class="col-4">
                <img class="w-100" src="{{asset($game->gameCover)}}" alt="game cover">
                <div class="mt-4">
                    <h1>{{$game->gameName}}</h1>
                    <p class="game-detail-text-light">{{$game->gameSummary}}</p>
                    <div class="d-flex game-detail-text">
                        <h4>Genre: <span class="game-detail-text-light">{{$game->genreId}}</span></h4>
                    </div>
                    <div class="d-flex game-detail-text">
                        <h4>Release Date: <span class="game-detail-text-light">{{$game->created_at->format('F d,Y')}}</span> </h4>
                    </div>
                    <div class="d-flex game-detail-text">
                        <h4>Game Developer: <span class="game-detail-text-light">{{$game->gameDeveloper}}</span> </h4>
                    </div>
                    <div class="d-flex game-detail-text">
                        <h4>Game Publisher: <span class="game-detail-text-light">{{$game->gamePublisher}}</span> </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- add to cart --}}
        @if(!$owned)
            <div class="d-flex add-to-cart-container align-items-center justify-content-between mt-5 p-5">
                <div>
                    <h1>
                        Buy {{$game->gameName}}
                    </h1>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-center">
                        <h3 class="m-0">
                            Rp.{{number_format($game->gamePrice)}}
                        </h3>
                    </div>
                        <div class="bg-dark px-3 py-1 rounded ms-5 ps-0">
                            <form action="#" method="post">
                                @csrf
                                <button class="d-flex align-items-center btn btn-dark text-decoration-none p-2 ps-0" href="#">
                                    <img class="nav-cart-icon p-2" src="{{asset('images/cart-icon.png')}}" alt="">
                                    <h5 class="m-0">
                                        ADD TO CART
                                    </h5>
                                </button>
                            </form>
                        </div>
                </div>
            </div>
        @endif

        <div class="mt-5">
            <h2 class="border-bottom border-dark pb-3 mb-3">About This Game</h2>
            <p class="game-detail-text-light">{{$game->gameDescription}}</p>
        </div>
    </div>
    @include('partials.footer')

</body>
</html>