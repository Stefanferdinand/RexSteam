<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
    
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    
    {{-- Bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    @include('partials.navigation')
    <div class="bg-light full">
        <h1 class="text-dark ms-5 pt-5 pb-4">Search Games</h1>

        @if ($games->count() > 0)
            <div class="p-3 pb-5">
                <div class="d-flex flex-wrap ms-5 me-3">
                    @foreach ($games as $item)
                        <div class="m-2 mb-5">
                            <a href="/game/adultOnly/{{$item->id}}">
                                <img src="{{$item->gameCover}}" alt="">
                            </a>
                            <div class="mt-3">
                                <h3>{{$item->gameName}}</h3>
                                <h5>{{$item->genreId}}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-end me-5">
                {{$games->links()}}
            </div>
        @else
            <h1 class="display-6 ms-5 pb-4">There is currently no game available.</h1>
        @endif      
        
    </div>
    @include('partials.footer')

</body>
</html>