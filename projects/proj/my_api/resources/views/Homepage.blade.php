<html>
    <body>
        <h1>Homepage</h1>
        {{ $message ?? '' }}
        @isset($message)
        <div>
            <form action="/">
                <button>
                    Logout
                </button>
            </form>
        </div>
        @endisset
        @empty($message)
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