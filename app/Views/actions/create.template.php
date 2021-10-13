<?php require_once 'app/Views/partials/header.template.php'; ?>
<form action="/actions" method="post">
    <label for="title">Title:</label>
    <input id="title" type="text" name="title">
    <button type="submit">Create</button>
</form>
(<a href="/actions">Back</a>)
</body>
</html>
