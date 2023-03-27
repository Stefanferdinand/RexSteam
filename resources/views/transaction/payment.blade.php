<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Verification</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    {{-- error handling --}}
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show fixed-top m-5" role="alert">
        <ul>
            @foreach ($errors->all() as $item)
                <li class="p-2">{{$item}}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @include('partials.navigation')
    <div class="bg-light p-5">
        <h1>Transaction Information</h1>
        <form class="transaction-information-form" action="/transaction/receipt" method="post">
            @csrf
            <div class="form-row">
                <label for="cardName">Card Name</label>
                <br/>
                <input placeholder="Card Name" type="text" name="cardName">
                <br/>
            </div>
            
            <div class="form-row">
                <label for="cardNumber">Card Number</label>
                <br/>
                <input placeholder="0000 0000 0000 0000" type="text" name="cardNumber">
                <br/>
                <p class="text-muted mt-3">Visa or Master card</p>
            </div>

            <div>
                <div class="d-flex justify-content-between form-row">
                    <div class="col-8">
                        <label for="expiredDate">Expired Date</label>
                        <div class="d-flex justify-content-between">
                            <input class="col me-5 ps-3" placeholder="MM" type="text" name="month">
                            <input class="col me-5 ps-3" placeholder="YYYY" type="text" name="year">
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="cvccvv">CVC/CVV</label>
                        <input class="ps-3" placeholder="3 or 4 digit numbers" type="text" name="cvccvv">
                    </div>
                </div>
                <div class="d-flex form-row">
                    <div class="col-8">
                        <label for="country">Country</label>
                        <div class="me-5">
                            <select class="ps-3" name="country" id="country">
                                <option value="Indonesia">Indonesia</option>
                                <option value="America">America</option>
                                <option value="Zimbabwe">Zimbabwe </option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-4">
                        <label for="zip">Zip</label>
                        <input class="ps-3" placeholder="Zip" type="text" name="zip">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-5">
                <div class="col d-flex align-items-center">
                    <h2>Total Price: </h2>
                    <h3 class="ms-3">Rp.{{number_format($totalPrice)}}</h3>
                </div>
                <div class="d-flex justify-content-end col">
                    <a class="cancel-payment-btn btn btn-secondary my-auto d-flex align-items-center justify-content-center me-5 w-25" href="/user/cart">Cancel</a>
                    <button class="btn btn-dark p-2 w-25" type="submit">Checkout</button>
                </div>
            </div>
        </form>
    </div>
    @include('partials.footer')

</body>
</html>