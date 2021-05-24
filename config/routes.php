<?php
//маршруты по которым можно ходить
    return array(
        'news/([0-9]+)' => 'news/view/$1',
        'news' => 'news/index',
        'create' => 'news/create',
        'delete/([0-9]+)' => 'news/delete/$1',
//        'products'=>'product/list', //actioIndex in NewsController

    );