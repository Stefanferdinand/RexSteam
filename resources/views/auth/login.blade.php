<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
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

     @else
        @if(Session::get('errors'))
        <div class="alert alert-danger alert-dismissible fade show fixed-top m-5" role="alert">
            <ul>
                {{Session::get('errors')}}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
     @endif

    <div class="auth d-flex w-auto">
        <div class="auth-container auth-p">
            <h1 class="text-light mb-4">Login</h1>
            <form class="auth-form" action="#" method="POST">
                @csrf
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
                <br/>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <br/>
                <div class="d-flex align-items-center">
                    <input class="checkboxes" type="checkbox" name="rememberMe" id="rememberMe">
                    <label class="ms-3" for="rememberMe">Remember Me</label>
                </div>
                <br/>
                <button type="submit">Sign In</button>
            </form>
            <a class="auth-redirect" href="./register">Don't have an account?</a>
        </div>
        <div>
            <img class="h-100" src="{{asset('images/steam-train.jpg')}}" alt="steam-train">
        </div>
    </div>

    {{-- Bootstrap js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>