<?php

use mysql_xdevapi\DatabaseObject;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string $title
 * @property DatabaseObject $date
 * @property string $short_content
 * @property string $content
 * @property string $author_name
 * @property string $preview
 * @property string $type
 */

    class News{

        /**
         * @param integer $id
         * @return mixed $newsItem
         */
        public static function getNewsItemById($id){
            $id = intval($id);

            if ($id) {
                $db = Db::getConnection();
                $result = $db->query("SELECT * FROM news WHERE id=" . $id);

                $result->setFetchMode(PDO::FETCH_ASSOC);
                $newsItem = $result->fetch();

                return $newsItem;
            }
        }

        /**
         * @return array $newsList
         */
        public static function getNewsList(){
            $db = Db::getConnection();

            $newsList = array();

            $result = $db->query('SELECT id, title, date, short_content FROM news ORDER BY date DESC LIMIT 10');

            $i = 0;

            while($row = $result->fetch()) {
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