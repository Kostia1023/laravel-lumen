<html>
<body>

<form action="/register" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
password: <input type="text" name="password"><br>
confirm password: <input type="text" name="confirmPassword"><br>
<input type="submit">
</form>
{{ $records ?? '' }}
</body>
</html>