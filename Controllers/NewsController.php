<?php
include_once ROOT.'/models/News.php';

    class NewsController
    {

        public function actionIndex()
        {
            $newsList = array();
            $newsList = News::getNewsList();

           require_once(ROOT . '/views/news/index.php');
//            echo '<pre>';
//            print_r($newsList);
//            echo '<pre>';
//            return true;
        }

        public function actionView ($id){
            if ($id) {
                $newsItem = News::getNewsItemByID($id);
//                print_r($newsItem);
               require_once(ROOT . '/views/news/view.php');
            }
            return true;
        }

        public function actionCreatnew(){
            News::setNewNews($_POST['title'],$_POST['short_content'],$_POST['content'],$_POST['author_name'],$_POST['preview'],$_POST['type']);
            $filename = News::uploadImage($_FILES['image']);
           addPost($_POST['title'], $_POST['content'], $filename);
            require_once(ROOT . '/views/news/creatnew.php');
        }
        //$title, $short_content, $content, $author_name, $preview, $type
//    require 'Post.php';
//    require 'list.php';
//
//    $filename = uploadImage($_FILES['image']);
//    addPost($_POST['title'], $_POST['content'], $filename);
//
//    header("Location:/");
//
//    var_dump($_POST);





    }