<html>
    <body>
        <h1>Homepage</h1>
        @auth
         <div> <p>Hello</p>.</div>
        @endauth
 
        @guest
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
        @endguest
    </body>
</html>