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
    public static function createProduct($options)
    {
        $db = Db::getConnection();
        $result = $db->query('INSERT INTO news (title, short_content, content, author_name, preview, type) VALUES (:title, :short_content, :content, :author_name, :preview, :type)');
        $result->bindParam(":title", $options['title'], PDO::PARAM_STR);
        $result->bindParam(":short_content", $options['short_content'], PDO::PARAM_STR);
        $result->bindParam(":content", $options['content'], PDO::PARAM_STR);
        $result->bindParam(":author_name", $options['author_name'], PDO::PARAM_STR);
        $result->bindParam(":preview", $options['preview'], PDO::PARAM_STR);
        $result->bindParam(":type", $options['type'], PDO::PARAM_STR);

        $result->execute();
    }
//    /**
//     * Добавляет новый товар
//     * @param array $options <p>Массив с информацией о товаре</p>
//     * @return integer <p>id добавленной в таблицу записи</p>
//     */
//    public static function createProduct($options)
//    {
//        // Соединение с БД
//        $db = Db::getConnection();
//
//        // Текст запроса к БД
//        $sql = 'INSERT INTO product '
//            . '(name, code, price, category_id, brand, availability,'
//            . 'description, is_new, is_recommended, status)'
//            . 'VALUES '
//            . '(:name, :code, :price, :category_id, :brand, :availability,'
//            . ':description, :is_new, :is_recommended, :status)';
//
//        // Получение и возврат результатов. Используется подготовленный запрос
//        $result = $db->prepare($sql);
//        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
//        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
//        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
//        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
//        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
//        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
//        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
//        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
//        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
//        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
//        if ($result->execute()) {
//            // Если запрос выполенен успешно, возвращаем id добавленной записи
//            return $db->lastInsertId();
//        }
//        // Иначе возвращаем 0
//        return 0;
//    }





//загрузка картинки
    public static function uploadImage($image)
    {
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $extension;
        move_uploaded_file($image['tmp_name'], "uploads/" . $filename);
        return $filename;
    }
}