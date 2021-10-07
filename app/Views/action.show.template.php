<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo list</title>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-6">
            <div class="p-4 bg-white notes">
                <div class="d-flex flex-row align-items-center notes-title">
                    <h4>TODO list</h4><span class="px-2 review-text ml-2 rounded"></span>
                </div>
                <div class="p-3 bg-white">
                    <?php foreach ($list as $action): ?>
                        <div class="d-flex align-items-center"><label><input type="checkbox"
                                                                             class="option-input radio"><span
                                        class="label-text"><?php echo $action[0] ?></span></label></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
</body>
</html>
