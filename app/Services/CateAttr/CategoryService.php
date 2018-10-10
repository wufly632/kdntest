<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Repositories\CateAttr\CategoryRepository;

class CategoryService{

    /**
     * @var CategoryRepository
     */
    protected $category;


    /**
     * GoodsController constructor.
     *
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }



}