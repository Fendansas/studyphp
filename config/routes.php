<?php
//маршруты по которым можно ходить
    return array(
        'news/([0-9]+)' => 'news/view/$1',
        'news' => 'news/index',
//        'products'=>'product/list', //actioIndex in NewsController

    );