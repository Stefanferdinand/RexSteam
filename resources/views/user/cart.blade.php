<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Cart</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    {{-- delete --}}
    @if (Session::has('gameId'))
        <div class="game-delete-container position-fixed">
            <h1>Delete Cart?</h1>
            <p>Are you sure you want to delete this game from your cart? All your data will be lost. This action cannot be undone.</p>
            <div class="d-flex justify-content-end align-items-center mt-5">
                <a href="cart/">
                    <button class="game-delete-btn btn btn-dark me-3" type="button">Cancel</button>
                </a>
                <form action="/user/cart/deleteItem/{{Session::get('gameId')}}" method="post">
                    @csrf
                    <button class="game-delete-btn btn btn-danger ms-3" type="submit">Delete</button>
                </form>
            </div>
        </div>
    @endif   

    @include('partials.navigation')
    <div class="bg-light p-5 full">
        <h1>Shopping Cart</h1>
        @if($games->count() > 0)
            <div class="bg-white border border-dark mt-5">
                @foreach ($games as $item)
                    <div class="d-flex align-items-center justify-content-between p-5">
                        <div class="d-flex align-items-center">
                            <a href="/game/{{$item->id}}">
                                <img src="{{asset($item->gameCover)}}" alt="{{$item->gameName}}">
                            </a>
                            <div class="d-flex justify-content-start flex-column ms-5">
                                <div class="d-flex align-items-center mb-2">
                                    <h2 class="me-3 mb-0">{{$item->gameName}}</h2>
                                    <span class="badge rounded-pill bg-dark d-flex align-items-center cart-badge px-4">{{$item->genreId}}</span>
                                </div>
                                <div class="d-flex mt-2">
                                    <img class="price-tag me-4" src="{{asset("images/price-tag-icon.png")}}" alt="">
                                    <h5>Rp.{{number_format($item->gamePrice)}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="cart-delete-btn">
                            <a class="d-flex align-items-center justify-content-center text-decoration-none text-dark p-3 rounded" href="cart/deleteItem/{{$item->id}}">
                                <img class="me-3" width="30px" height="30px" src="{{asset("images/trash-icon.png")}}" alt="delete">
                                <h3 class="m-0">Delete</h3>
                            </a>
                        </div>
                    </div>
                    <hr/>
                @endforeach
                <div class="d-flex justify-content-between">
                    <h2 class="p-5">Total Price: </h2>
                    <div class="d-flex flex-column align-items-start p-5">
                        <h3>Rp.{{number_format($totalPrice)}}</h3>
                        <form action="/transaction/payment" method="get">
                            <button class="btn btn-dark" type="submit">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <h1 class="display-6 mt-5 pb-4">There is currently no game in your cart.</h1>
        @endif

    </div>
    @include('partials.footer')

</body>
</html>