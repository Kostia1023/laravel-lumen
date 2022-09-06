<html>
<body>

<form action="/login" method="post">
E-mail: <input type="text" name="email"><br>
password: <input type="text" name="password"><br>
<input type="submit">
</form>
{{ $records ?? '' }}
</body>
</html>