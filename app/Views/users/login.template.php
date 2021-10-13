<?php require_once 'app/Views/partials/header.template.php'; ?>
<form action="/login" method="post">
    <label for="email">E-Mail:</label>
    <input id="email" type="email" name="email">
    <br>
    <label for="password">Password:</label>
    <input id="password" type="password" name="password">
    <br>
    <button type="submit">Register</button>
</form>
(<a href="/">Back</a>)
</body>
</html>
