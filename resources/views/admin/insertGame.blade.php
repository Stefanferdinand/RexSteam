<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Game</title>

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
    <div class="bg-light">
        <h1 class="ms-5 pt-5 pb-5">Create Game</h1>
        <form class="game-form ms-5 me-5 pb-5" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- name --}}
            <label for="gameName">Game Name</label>
            <br/>
            <input type="text" name="gameName">
            <br/>
            {{-- summary --}}
            <label for="gameSummary">Game Summary</label>
            <br/>
            <textarea name="gameSummary" id="gameSummary" cols="30" rows="10"></textarea>
            <br/>
            {{-- description --}}
            <label for="gameDescription">Game Description</label>
            <br/>
            <textarea name="gameDescription" id="gameDescription" cols="30" rows="10"></textarea>
            <br/>
            {{-- genre --}}
            <label for="gameGenre">Game Genre</label>
            <br/>
            <select name="gameGenre" id="gameGenre">
                @foreach ($gameGenres as $item)
                    <option value="{{$item->genreName}}">{{$item->genreName}}</option>
                @endforeach
            </select>
            <br/>
            {{-- developer --}}
            <label for="gameDeveloper">Game Developer</label>
            <br/>
            <input type="text" name="gameDeveloper">
            <br/>
            {{-- publisher --}}
            <label for="gamePublisher">Game Publisher</label>
            <br/>
            <input type="text" name="gamePublisher">
            <br/>
            {{-- price --}}
            <label for="gamePrice">Game Price</label>
            <br/>
            <input type="number" name="gamePrice">
            <br/>
            {{-- cover --}}
            <label for="gameCover">Game Cover</label>
            <br/>
            <input type="file" name="gameCover">
            <br/>
            {{-- trailer --}}
            <label for="gameTrailer">Game Trailer</label>
            <br/>
            <input type="file" name="gameTrailer">
            <br/>
            {{-- adultOnly --}}
            <div class="d-flex align-items-center">
                <input class="checkboxes m-0 me-2" type="checkbox" name="adultOnly">
                <label for="adultOnly">Only for Adult?</label>
            </div>
            <br/>
            <div class="d-flex justify-content-end align-items-center">
                <a class="btn game-btn btn-secondary my-auto me-3 d-flex align-items-center justify-content-center" href="/admin">Cancel</a>
                <button class="btn game-btn btn-dark m-0 p-0 ms-3" type="submit">Save</button>
            </div>
        </form>
    </div>
    @include('partials.footer')

</body>
</html>