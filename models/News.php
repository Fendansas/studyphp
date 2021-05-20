<?php

include_once ROOT.'components/Db.php';

    class News{

        public static function getNewsItemById($id){
            $id = intval($id);

            if ($id) {

                $db = Db::getConnection();
                $result = $db->query('SELECT * FROM news WHERE id=' . $id);

                /*$result->setFetchMode(PDO::FETCH_NUM);*/
                $result->setFetchMode(PDO::FETCH_ASSOC);

                $newsItem = $result->fetch();

                return $newsItem;
            }
        }

        public static function getNewsList(){
            	$host = 'localhost';
                    $dbname = 'mydb';
                    $user = 'root';
                    $password = 'root';
                    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
           // $db = Db::getConnection();
            $link = mysqli_connect("localhost", "root", "root");

            if ($link == false){
                print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
            }
            else {
                print("Соединение установлено успешно");
            }
            $sql = "SELECT * FROM news";
            $statement = $db->prepare($sql);
            $statement->execute();
            $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
            print_r($posts);


            $newsList = array();

            $result = $db->query('SELECT id, title, date, short_content FROM news ORDER BY data DESC LIMIT 10');

            $i = 0;
            while($row = $result->fetch()) {
                $newsList[$i]['id'] = $row['id'];
                $newsList[$i]['title'] = $row['title'];
                $newsList[$i]['date'] = $row['date'];
                $newsList[$i]['short_content'] = $row['short_content'];
                $i++;
            }

            return $newsList;

        }
    }