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

    class News
    {

        /**
         * @param integer $id
         * @return mixed $newsItem
         */
        public static function getNewsItemById($id)
        {
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
        public static function getNewsList()
        {
            $db = Db::getConnection();
            $newsList = array();
            $result = $db->query('SELECT id, title, date, short_content, content FROM news ORDER BY date DESC LIMIT 10');

            $i = 0;
            while ($row = $result->fetch()) {
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

//              Создаю новую новость
    public static function setNewNews($title, $short_content, $content, $author_name, $preview, $type)
    {
        $db = Db::getConnection();
        $result = $db->query('INSERT INTO news (title, short_content, content, author_name, preview, type) VALUES (:title, :short_content, :content, :author_name, :preview, :type)');
        $result->bindParam(":title", $title);
        $result->bindParam(":short_content", $short_content);
        $result->bindParam(":content", $content);
        $result->bindParam(":author_name", $author_name);
        $result->bindParam(":preview", $preview);
        $result->bindParam(":type", $type);

        $result->execute();
    }
//загрузка картинки
    public static function uploadImage($image)
    {
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $extension;
        move_uploaded_file($image['tmp_name'], "uploads/" . $filename);
        return $filename;
    }
}