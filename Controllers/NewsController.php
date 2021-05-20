<?php
include_once ROOT.'/models/News.php';

    class NewsController
    {

        public function actionIndex()
        {
            $newsList = array();
            $newsList = News::getNewsList();

           //require_once(ROOT . '/views/news/index.php');
            echo '<pre>';
            print_r($newsList);
            echo '<pre>';
            return true;
        }

        public function actionView ($id){
            if ($id) {
                $newsItem = News::getNewsItemByID($id);
                print_r($newsItem);
              //  require_once(ROOT . '/views/news/view.php');


            }

            return true;


            return true;

        }
    }