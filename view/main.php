<?php
include 'list.php';
?>
<?php foreach($posts as $post):?>
    <p><img src="/uploads/<?=$post['image'];?>" width="50"></p>
<h1><?=$post['title'];?></h1>
<h1><?=$post['content'];?></h1>

<?php endforeach;?>

