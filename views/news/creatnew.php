<form action="../store.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title"><br>
    <input type="text" name="short_content"><br>
    <textarea name="content"></textarea><br>
    <input type="text" name="author_name"><br>
    <input type="text" name="preview"><br>
    <input type="text" name="type"><br>


<!--    $newsList[$i]['id'] = $row['id'];-->
<!--    $newsList[$i]['title'] = $row['title'];-->
<!--    $newsList[$i]['date'] = $row['date'];-->
<!--    $newsList[$i]['short_content'] = $row['short_content'];-->
<!--    //                $newsList[$i]['content'] = $row['content'];-->
<!--    //                $newsList[$i]['author_name'] = $row['author_name'];-->
<!--    //                $newsList[$i]['preview'] = $row['preview'];-->
<!--    //                $newsList[$i]['type'] = $row['type'];-->


    <input type="file" name="image"><br><br>
    <button type="submit"> Submit</button>
</form>