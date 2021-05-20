<?php



    class News{

        public static function getNewsItemById($id){
            $id = intval($id);

            if ($id) {
                $host = 'localhost';
                $dbname = 'mydb';
                $user = 'root';
                $password = 'root';
                $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

                //$db = Db::getConnection();
                $result = $db->query("SELECT * FROM news WHERE id=" . $id);

                /*$result->setFetchMode(PDO::FETCH_NUM);*/
                $result->setFetchMode(PDO::FETCH_ASSOC);

                $newsItem = $result->fetch();

                //print_r($newsItem);


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
//            //-----проверяю подключение
//            $link = mysqli_connect("localhost", "root", "root");
//            if ($link == false){
//                print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
//            }
//            else {
//                print("Соединение установлено успешно");
//            }
//            $sql = "SELECT * FROM news";
//            $statement = $db->prepare($sql);
//            $statement->execute();
//            $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
//            print_r($posts);
//--------------------------------------------------

            $newsList = array();

            $result = $db->query('SELECT id, title, date, short_content FROM news ORDER BY date DESC LIMIT 10');

            $i = 0;

            while($row = $result->fetch()) {
//                print_r($row);
//                print_r($newsList[$i]['id'] );
//                print_r($newsList[$i]['title']);

                $newsList[$i]['id'] = $row['id'];
                $newsList[$i]['title'] = $row['title'];
                $newsList[$i]['date'] = $row['date'];
                $newsList[$i]['short_content'] = $row['short_content'];
//                $newsList[$i]['content'] = $row['content'];
//                $newsList[$i]['author_name'] = $row['author_name'];
//                $newsList[$i]['preview'] = $row['preview'];
//                $newsList[$i]['type'] = $row['type'];

                $i++;
            }


            return $newsList;



        }
    }