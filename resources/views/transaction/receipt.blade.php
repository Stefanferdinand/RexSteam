<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Receipt</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    @include('partials.navigation')
    <div class="bg-light p-5 full">
        <h1>Transaction Receipt</h1>
        <div class="bg-white border border-dark mt-5">
            <div class="p-5 pb-2">
                <h3>Transaction ID: {{$transaction->id}}</h3>
                <h3>Purchase Date: {{$transaction->purchaseDate}} UTC</h3>
            </div>
            <hr/>
            
            <div>
                @foreach ($games as $item)
                    <div class="d-flex align-items-center justify-content-between p-5">
                        <div class="d-flex align-items-center">
                            <img src="{{asset($item->gameCover)}}" alt="{{$item->gameName}}">
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
                    </div>
                    <hr/>
                @endforeach
            </div>
            <div class="d-flex p-5">
                <h2>Total Price: </h2>
                <h3 class="ms-3 mb-0">Rp.{{number_format($transaction->totalPrice)}}</h3>
            </div>
        </div>
    </div>
    @include('partials.footer')

</body>
</html>