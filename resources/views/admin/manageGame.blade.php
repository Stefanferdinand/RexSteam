<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage Game</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
    {{-- success --}}
    @if(Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show fixed-top m-5" role="alert">
            {{Session::get('status')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- delete --}}
    @if (!empty($gameId))
        <div class="game-delete-container position-fixed">
            <h1>Delete Game?</h1>
            <p>Are you sure you want to delete this game? All your data will be lost. This action cannot be undone.</p>
            <div class="d-flex justify-content-end align-items-center mt-5">
                <a href="/admin">
                    <button class="game-delete-btn btn btn-dark me-3" type="button">Cancel</button>
                </a>
                <form action="/admin/deleteGame/{{$gameId}}" method="post">
                    @csrf
                    <button class="game-delete-btn btn btn-danger ms-3" type="submit">Delete</button>
                </form>
            </div>
        </div>
    @endif    

    @include('partials.navigation')
    <div class="bg-light full">
        <h1 class="text-dark ms-4 ps-5 pt-5 pb-5">Manage Games</h1>
        <div class="game-panel ps-5 ms-4 pb-5">
            <form action="/admin/searchGame" method="get">
                <div class="mb-4">
                    <h4>Filter by Games Name</h4>
                    <div class="d-flex game-search-container align-items-center">
                        <img class="game-search-icon" src="{{asset('images/search-icon.png')}}" alt="search-icon">
                        <input class="game-search" placeholder="Game Name" type="search" name="gameSearch" id="gameSearch">
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <h4>Filter by Games Genre</h4>
                    <div class="game-genre-container">
                        @foreach ($gameGenres as $item)
                        <div class="d-flex align-items-center">
                            <input class="checkboxes" type="checkbox" name="genres[{{$item->genreName}}]">
                            <div class="game-genre-item">{{$item->genreName}}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-dark p-2 m-0 w-25" type="submit">Search</button>
            </form>
            <a href="/admin/insertGame">
                <div class="d-flex align-items-center justify-content-center add-game-btn rounded-circle p-5 bg-primary">
                    <img class="add-game-icon" src="{{asset('images/add-game-icon.png')}}" alt="add game">
                </div>
            </a>
        </div>

        <div>
            @if (!empty($games->items())))
                <div class="p-3 pb-5">
                    <div class="d-flex flex-wrap ms-5 me-3 mb-5">
                        @foreach ($games as $item)
                            <div class="m-2 mb-5">
                                <a href="/game/adultOnly/{{$item->id}}">
                                    <img src="{{$item->gameCover}}" alt="">
                                </a>
                                <div class="mt-3">
                                    <h3>{{$item->gameName}}</h3>
                                    <h5>{{$item->genreId}}</h5>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a class="me-2" href="/admin/updateGame/{{$item->id}}">
                                        <button class="btn btn-primary" type="button">Update</button>
                                    </a>
                                    <a class="ms-2" href="/admin/deleteGame/{{$item->id}}">
                                        <button class="btn btn-danger" type="button">Delete</button>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end me-5">
                        {{$games->links()}}
                    </div>
                </div>
            @else
                <h1 class="display-6 ms-5 ps-4 pb-4">There is currently no game available.</h1>
            @endif    
        </div>

    </div>
    @include('partials.footer')
    
</body>
</html>