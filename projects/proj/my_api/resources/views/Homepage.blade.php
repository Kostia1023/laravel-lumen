<html>
    <body>
        <h1>Homepage</h1>
        @if(!empty($user))
        <div>
            <p>Wellcom {{$user->name}}</p>
            <form action="/logout" method="post">
                <button>
                    Logout
                </button type="submit">
            </form>
        </div>
        @endif
        @empty($user)
        <div><div>
            <form action="/page/register">
                <button>
                    register
                </button>
            </form>
        </div>
        <div>
            <form action="/page/login">
                <button>
                    Login
                </button>
            </form>
        </div> </div> 
        @endempty
    </body>
</html>