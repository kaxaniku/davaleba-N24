<?php

namespace Pages;

use Models\NewsModel;
use Models\CategoriesModel;
use Helpers\Pager;


class News extends Page{

    function __construct() {
        $this->model = new NewsModel();
        $this->model1 = new CategoriesModel();
        Parent::__construct();
    }
    
    public function index() {
        $CATID = isset($_GET["CategoryId"]) && $_GET["CategoryId"]? $_GET["CategoryId"] : null;

        $word = isset($_GET["word"]) && $_GET["word"]? $_GET["word"] : null;

        $page = isset($_GET['p']) && $_GET['p'] > 0 ? $_GET['p'] : 1 ;
        $limit = 4;
        $offset = ($page * $limit) - $limit;

        $cnt = $this->model->FilterCNT($CATID,$word);

        $this->data['pager'] = Pager::execute($cnt['cnt'], $limit, $page, '?page=news');


        $this->data['news'] = $this->model->GET_ALL_FILTERED($CATID,$word,$limit,$offset);

        $this->data['categories'] = $this->model1->getCategories();

        $this->data['word'] = $word;

        $this->data['CategoryId'] = $CATID;

        
        $this->load('views/frontend/news/index.php');

    }
    public function view() {
        $id = $_GET['id'];

        $this->data['news'] = $this->model->GET_SINGLE($id);
        
        $this->load('views/frontend/news/view.php');

    }
}