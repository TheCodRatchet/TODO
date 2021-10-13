<?php require_once 'app/Views/partials/header.template.php'; ?>
<h1>Tasks</h1> (<a href="/actions/create">Create</a>)
<ul>
    <?php foreach ($actions->getActions() as $action): ?>
        <li>
            <a href="/actions/<?php echo $action->getId(); ?>">
                <?php echo $action->getName(); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
