<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <title>
        <?= $title ?>
    </title>

</head>

<body>
    <h3>USUARIOS</h3>
    <ul>
        <?php foreach ($u as $item): ?>
        <li>
            <?= $item ?>
        </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>