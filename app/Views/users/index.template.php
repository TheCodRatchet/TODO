<?php require_once 'app/Views/partials/header.template.php'; ?>
<h1>Users</h1> (<a href="/">Create</a>)
<ul>
    <?php foreach ($users->getUsers() as $user): ?>
        <li>
            <?php echo $user->getName(); ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
