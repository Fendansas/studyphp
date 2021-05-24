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

        public function actionView($id)
        {
            if ($id) {
                $newsItem = News::getNewsItemByID($id);
//                print_r($newsItem);
                require_once(ROOT . '/views/news/view.php');
            }
            return true;
        }

        public function actionCreate()
        {
            echo "hi ";

            if (isset($_POST['submit'])) {
                echo 'hello ';
                // Если форма отправлена
                // Получаем данные из формы
                var_dump($_POST);
                $options['title'] = $_POST['title'];
                $options['short_content'] = $_POST['short_content'];
                $options['content'] = $_POST['content'];
                $options['author_name'] = $_POST['author_name'];
                $options['preview'] = $_POST['preview'];
                $options['type'] = $_POST['type'];


                    // Флаг ошибок в форме
                    $errors = false;

                    // При необходимости можно валидировать значения нужным образом
                    if (!isset($options['title']) || empty($options['title'])) {
                        $errors[] = 'Заполните поля';
                    }

                    echo 'имя не пустое';
                    if ($errors == false) {
                        // Если ошибок нет
                        // Добавляем новый товар

                        echo 'creteNews ';
                        $id = News::createNews($options);

                        // Если запись добавлена
                        if ($id) {
                            // Проверим, загружалось ли через форму изображение
                            if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                                // Если загружалось, переместим его в нужную папке, дадим новое имя
                                move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/views/images/{$id}.jpg");
                            }
                        }

                        //Перенаправляем пользователя на главную
                       header("Location: /news");
                    }

            }
            // Подключаем вид
            require_once(ROOT . '/views/news/create.php');
            return true;
        }


        /**
         * Action для страницы "Удалить новость"
         */
        public function actionDelete($id)
        {

            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена
                // Удаляем товар
                Product::deleteProductById($id);

                // Перенаправляем пользователя на страницу управлениями товарами
               header("Location: /news");
            }

            // Подключаем вид
            require_once(ROOT . '/views/news/delete.php');
            return true;
        }
    }