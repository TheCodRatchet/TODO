<?php require_once 'app/Views/partials/header.template.php'; ?>
<h1><?php echo $action->getName(); ?></h1>
<form method="post" action="/actions/<?php echo $action->getId() ?>">
    <button type="submit" onclick="return confirm('Are you sure You want to delete this Action?')">X</button>
</form>
(<a href="/actions">Back</a>)
</body>
</html>