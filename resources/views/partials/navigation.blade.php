
{{-- Bootstrap js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<div class="d-flex row nav-container pt-4 pb-4 pe-5">
    
    <div class="d-flex align-items-center col-6">
        <h1 class="ms-5 text-light">ReXSteam</h1>
        {{-- member & guest --}}
        <a class="nav-links ms-5" href="/">Home</a>

        @if(Auth::check())
            @if(Auth::user()->roleId == 1)
                {{-- admin --}}
                <a class="nav-links ms-5" href="/admin">Manage Game</a>
            @endif
        @endif
    </div>

    <div class="d-flex align-items-center justify-content-around col-6">
        {{-- search bar --}}
        <div class="d-flex col-7">
            <div class="d-flex align-items-center col-11">
                <img class="nav-search-icon" src="{{asset('images/search-icon.png')}}" alt="search-icon">
                <input class="nav-search col py-3" placeholder="Search" onkeypress="enter(event)" type="search" name="search" id="search">
            </div>
        </div>

        <div class="d-flex justify-content-around col-5 align-items-center">

            {{-- guest --}}
            @if(!Auth::check())
                <a class="nav-links" href="/auth/login">Login</a>
                <a class="nav-links" href="/auth/register">Register</a>

            @else
                {{-- member--}}
                @if(Auth::user()->roleId == 2)
                    <a href="/user/cart"><img class="nav-cart-icon" src="{{asset('images/cart-icon.png')}}" alt="cart-icon"></a>
                    <div class="dropdown"  data-toggle="dropdown">

                        <img class="nav-profile-picture rounded-circle dropdown-toggle" id="dropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"src="{{Auth::user()->profilePicture}}" alt="">
            
                        <div class="dropdown-menu nav-pd-menu" aria-labelledby="dropdownMenu">
                            <a class="dropdown-item" href="/user/profile">Profile</a>
                            <a class="dropdown-item" href="/user/friend">Friends</a>
                            <a class="dropdown-item" href="/user/history">Transaction History</a>
                            <a class="dropdown-item" href="/auth/logout">Sign Out</a>
                        </div>
                    </div>
                @endif

                {{-- admin --}}
                @if(Auth::user()->roleId == 1)
                    <div class="dropdown"  data-toggle="dropdown">

                        <img class="nav-profile-picture rounded-circle dropdown-toggle" id="dropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"src="{{Auth::user()->profilePicture}}" alt="">

                        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <a class="dropdown-item" href="/user/profile">Profile</a>
                            <a class="dropdown-item" href="/auth/logout">Sign Out</a>
                        </div>
                    </div>
                @endif
            @endif
        
        </div>

    </div>
</div>

{{-- enter for search bar --}}
<script>
    function enter(e){
        if(e.keyCode == 13){
            var q = document.getElementById('search').value;
            window.location = "/search/" + q;
        }
    }
</script>