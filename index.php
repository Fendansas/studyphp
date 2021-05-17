<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сисок дел</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Список дел</h1>
        <form action="/add.php" method="post">
            <input type="text" name="task" id="task" placeholder="Нужно сделать..." class="form-control">
            <button type="submit" name="sandTask" class="btn btn-success">Отправить</button>
        </form>
        <?php
        require 'configDB.php';

        echo '<ul>';
        $query = $pdo->query('SELECT * FROM `tasks` ORDER BY `id` DESC');
        while($row = $query->fetch(PDO::FETCH_OBJ)) {
            echo '<li><b>'.$row->task.'</b><a href="/delete.php?id='.$row->id.'"><button>Удалить</button>

            <a class="rating-area">
                <input type="radio" id="star-5" name="rating" value="5">
                <label for="star-5" title="Оценка «5»"></label>	
                <input type="radio" id="star-4" name="rating" value="4">
                <label for="star-4" title="Оценка «4»"></label>    
                <input type="radio" id="star-3" name="rating" value="3">
                <label for="star-3" title="Оценка «3»"></label>  
                <input type="radio" id="star-2" name="rating" value="2">
                <label for="star-2" title="Оценка «2»"></label>    
                <input type="radio" id="star-1" name="rating" value="1">
                <label for="star-1" title="Оценка «1»"></label>
            </a>
            
            </a></li>';
        }
        echo '</ul>';
        ?>
    </div>
</body>
</html>