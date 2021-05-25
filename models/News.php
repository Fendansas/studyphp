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
                $i++;
            }
            return $newsList;
        }


    /**
     * Создание новой новости.
     * @param $options
     */
    public static function createNews($options)
    {
        $db = Db::getConnection($options);
        echo 'connect to db ';
        //`id`, `title`, `date`, `short_content`, `content`, `author_name`, `preview`, `type`, `image`
        $result = $db->prepare('INSERT INTO news (title, short_content, content, author_name, preview, type) VALUES (:title, :short_content, :content, :author_name, :preview, :type)');
        $result->bindParam(":title", $options['title'], PDO::PARAM_STR);
        $result->bindParam(":short_content", $options['short_content'], PDO::PARAM_STR);
        $result->bindParam(":content", $options['content'], PDO::PARAM_STR);
        $result->bindParam(":author_name", $options['author_name'], PDO::PARAM_STR);
        $result->bindParam(":preview", $options['preview'], PDO::PARAM_STR);
        $result->bindParam(":type", $options['type'], PDO::PARAM_STR);
        $res = $result->execute();
        if ($res){
            echo 2;
          return $db->lastInsertId();
        }else{
            var_dump($result->errorInfo());
        }
        return 0;
    }

    public static function getImage($id)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/views/images/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

        /**
         * Удаляет товар с новость id
         * @param integer $id <p>id товара</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function deleteNewsById($id)
        {
            // Соединение с БД
            $db = Db::getConnection();

            // Текст запроса к БД
            $sql = 'DELETE FROM news WHERE id = :id';

            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            return $result->execute();
        }

        /**
         * Редактирует новость с заданным id
         * @param integer $id <p>id новости</p>
         * @param array $options <p>Массив с информацей о новости</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function updateNewsById($id, $options)
        {
            // Соединение с БД
            $db = Db::getConnection();


//            title, short_content, content, author_name, preview, type
            // Получение и возврат результатов. Используется подготовленный запрос
            $result = $db->prepare('UPDATE news SET title = :title, short_content = :short_content, content = :content, author_name = :author_name, preview = :preview, type = :type WHERE id = :id ');
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(":title", $options['title'], PDO::PARAM_STR);
            $result->bindParam(":short_content", $options['short_content'], PDO::PARAM_STR);
            $result->bindParam(":content", $options['content'], PDO::PARAM_STR);
            $result->bindParam(":author_name", $options['author_name'], PDO::PARAM_STR);
            $result->bindParam(":preview", $options['preview'], PDO::PARAM_STR);
            $result->bindParam(":type", $options['type'], PDO::PARAM_STR);
            $result->execute();

            return true;
        }





}