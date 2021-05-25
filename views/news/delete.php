<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li><a href="/admin/product">Управление тстатьями</a></li>
                        <li class="active">Удалить статью</li>
                    </ol>
                </div>


                <h4>Удалить товар #<?php echo $id; ?></h4>


                <p>Вы действительно хотите удалить этот статью ?</p>

                <form method="post">
                    <input type="submit" name="submit" value="Удалить" />
                </form>

            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>