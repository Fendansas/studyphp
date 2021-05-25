<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="#">Админпанель</a></li>
                        <li><a href="#">Управление новостями</a></li>
                        <li class="active">Редактировать новость</li>
                    </ol>
                </div>


                <h4>Редактировать товар #<?php echo $id; ?></h4>

                <br/>

                <div class="col-lg-4">
                    <div class="login-form">
                        <form action="#" method="post" enctype="multipart/form-data">

                            <p>Название</p>
                            <input type="text" name="title" placeholder="" value="<?php echo $news['title']; ?>">

                            <p>Короткое описание</p>
                            <input type="text" name="short_content" placeholder="" value="<?php echo $news['short_content']; ?>">

                            <p>Описание</p>
                            <input type="text" name="content" placeholder="" value="<?php echo $news['content']; ?>">


                            <p>Имя автора</p>
                            <input type="text" name="author_name" placeholder="" value="<?php echo $news['author_name']; ?>">

                            <p>preview</p>
                            <input type="text" name="preview" placeholder="" value="<?php echo $news['preview']; ?>">

                            <p>Тип</p>
                            <input type="text" name="type" placeholder="" value="<?php echo $news['type']; ?>">


                            <p>Изображение товара</p>
                            <img src="<?php echo News::getImage($news['id']); ?>" width="200" alt="" />
                            <input type="file" name="image" placeholder="" value="<?php echo $news['image']; ?>">

                            <br/><br/>

                            <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                            <br/><br/>


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>