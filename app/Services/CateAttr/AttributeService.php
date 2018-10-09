<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Entities\CateAttr\CategoryAttribute;
use App\Repositories\CateAttr\AttributeRepository;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Validators\CateAttr\CategoryAttributeValidator;

class AttributeService{

    /**
     * @var AttributeRepository
     */
    protected $attribute;


    /**
     * GoodsController constructor.
     *
     * @param AttributeRepository $attribute
     */
    public function __construct(AttributeRepository $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * 获取AttributeRepository
     *
     * @param void
     * @return object
     */
    public function getAttributeRepository()
    {
        return $this->attribute;
    }

}