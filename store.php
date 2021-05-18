<?php

require 'Post.php';
require 'list.php';

$filename = uploadImage($_FILES['image']);
addPost($_POST['title'], $_POST['content'], $filename);

header("Location:/");

var_dump($_POST);







