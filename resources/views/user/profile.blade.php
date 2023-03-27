<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>

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

    @if (Session::has('status'))
        <div class="alert alert-danger alert-dismissible fade show fixed-top m-5" role="alert">
            {{Session::get('status')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @include('partials.navigation')
    <div class="bg-light p-5 full">
        <div class="d-flex bg-white border border-dark mt-5">
            <div class="col-3 d-flex flex-column border-end pe-5 py-5 text-decoration-none">
                {{-- profile --}}
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h4>Profile</h4>
                </div>
                @if($user->roleId == 2)
                    {{-- friends --}}
                    <div class="ps-4 mb-5">
                        <a class="text-decoration-none text-dark" href="/user/friend">
                            <h4>Friends</h4>
                        </a>
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
                    <h2>{{$user->username}}'s Profile</h2>
                    <span class="text-muted">This information will be displayed publicly, be careful what you share.</span>
                </div>
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-9 mt-5">
                            <div class="row">
                                <div class="d-flex flex-column col-8">
                                    <label for="username">Username</label>
                                    <input class="form-control" type="text" placeholder="{{$user->username}}" disabled readonly>
                                </div>
                                <div class="d-flex flex-column col">
                                    <label for="level">Level</label>
                                    <input class="form-control" type="text" placeholder="{{$user->level}}" disabled readonly>
                                </div>
                            </div>
                            <div class="d-flex flex-column col mt-4">
                                <label for="fullname">Full Name</label>
                                <input class="form-control" type="text" name="fullname" id="fullname" placeholder="{{$user->fullname}}">
                            </div>
                        </div>
                        <div class="col-3 d-flex flex-column align-items-center">
                            <img class="rounded-circle" width="150px" height="150px" src="{{asset($user->profilePicture)}}" alt="">
                            <input class="form-control mt-2" type="file" name="profilePicture">
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex flex-column col mt-4">
                            <label for="currentPassword">Current Password</label>
                            <input class="form-control m-0 p-3 h-25 w-100" type="password" name="currentPassword">
                            <span class="text-secondary">Fill out the field to check if you are authorized.</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex flex-column col mt-4">
                            <label for="newPassword">New Password</label>
                            <input class="form-control m-0 p-3 h-25 w-100" type="password" name="newPassword">
                            <span class="text-secondary">Only if you want to change your password.</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex flex-column col mt-4">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input class="form-control m-0 p-3 h-25 w-100" type="password" name="confirmPassword">
                            <span class="text-secondary">Only if you want to change your password.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-dark w-25 h-25 p-2" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @include('partials.footer')

</body>
</html>