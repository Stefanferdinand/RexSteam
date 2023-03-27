<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friend</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    {{-- fail --}}
    @if(Session::has('fail'))
    <div class="alert alert-danger alert-dismissible fade show fixed-top m-5" role="alert">
        <div>{{Session::get('fail')}}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- success --}}
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show fixed-top m-5" role="alert">
        <div>{{Session::get('success')}}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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
                    <div class="border-start border-5 border-primary ps-4 mb-5">
                        <h4>Friends</h4>
                    </div>
                    {{-- transaction history --}}
                    <div class="ps-4 mb-5">
                        <a class="text-decoration-none text-dark" href="/user/history">
                            <h4>Transaction History</h4>
                        </a>
                    </div>
                @endif
            </div>


            <div class="col py-5 px-5 pb-3">
                <div>
                    <h2>Friends</h2>
                </div>
                <form class="mt-5" action="#" method="post">
                    @csrf
                    <h4>Add Friend</h4>
                    <div class="d-flex mt-3 align-items-start">
                        <input class="h-25 py-2 me-5 px-2" type="text" placeholder="Username" name="username">
                        <button class="btn btn-dark w-25 h-25 p-1 px-0 m-0" type="submit">Add</button>
                    </div>  
                </form>
                {{-- incoming --}}
                <div class="mt-5">
                    <h4>Incoming Friend Request</h4>
                    <div class="d-flex mt-3 align-items-start">
                        @if(count($incomingFriend) == 0)
                            <p class="text-secondary">There is no incoming friend request.</p>
                        @else
                            <div class="row mt-3">
                                @foreach ($incomingFriend as $item)
                                    <div class="shadow bg-light rounded me-3 mb-3 p-0"style="width:270px">
                                        <div class="d-flex flex-column border-bottom">
                                            <div class="d-flex p-4">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <h6 class="me-3">{{$item->username}}</h6>
                                                    {{$item->roleId}}
                                                </div>
                                                <div class="d-flex col">
                                                    <span class="badge rounded bg-success h-50">{{$item->level}}</span>
                                                </div>
                                                <div class="col ms-5">
                                                    <img class="rounded-circle" width="50px" height="50px" src="{{$item->profilePicture}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <a class="text-decoration-none text-success fw-bold border-end" href="/user/friend/accept/{{$item->id}}">
                                                <div class="d-flex align-items-center justify-content-center px-5 py-3">
                                                    Accept
                                                </div>
                                            </a>
                                            <a class="text-decoration-none text-danger fw-bold" href="/user/friend/reject/{{$item->id}}">
                                                <div class="d-flex align-items-center justify-content-center px-5 py-3">
                                                    Reject
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>  
                </div>
                {{-- pending --}}
                <div class="mt-5">
                    <h4>Pending Friend Request</h4>
                    <div class="d-flex mt-3 align-items-start">
                        @if(count($pendingFriend) == 0)
                            <p class="text-secondary">There is no pending friend request.</p>
                        @else
                            <div class="row mt-3">
                                @foreach ($pendingFriend as $item)
                                    <div class="shadow bg-light rounded me-3 mb-3 p-0" style="width:270px">
                                        <div class="d-flex flex-column border-bottom">
                                            <div class="d-flex p-4">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <h6 class="me-3">{{$item->username}}</h6>
                                                    {{$item->roleId}}
                                                </div>
                                                <div class="d-flex col">
                                                    <span class="badge rounded bg-success h-50">{{$item->level}}</span>
                                                </div>
                                                <div class="col ms-5">
                                                    <img class="rounded-circle" width="50px" height="50px" src="{{$item->profilePicture}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <a class="text-decoration-none text-danger fw-bold" href="/user/friend/cancel/{{$item->id}}">
                                            <div class="d-flex align-items-center justify-content-center px-5 py-3">
                                                Cancel
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>  
                </div>
                {{-- friend --}}
                <div class="mt-5">
                    <h4>Your Friends</h4>
                    <div class="d-flex mt-3 align-items-start">
                        @if(count($friend) == 0)
                            <p class="text-secondary">There is no friend.</p>
                        @else
                            <div class="row mt-3">
                                @foreach ($friend as $item) 
                                    <div class="shadow bg-light rounded me-3 mb-3 p-0">
                                        <div class="d-flex flex-column border-bottom">
                                            <div class="d-flex p-4">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <h6 class="me-3">{{$item->username}}</h6>
                                                    {{$item->roleId}}
                                                </div>
                                                <div class="d-flex col">
                                                    <span class="badge rounded bg-success h-50">{{$item->level}}</span>
                                                </div>
                                                <div class="col ms-5">
                                                    <img class="rounded-circle" width="50px" height="50px" src="{{$item->profilePicture}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>  
                </div>
            </div>

        </div>
    </div>
    @include('partials.footer')

</body>
</html>