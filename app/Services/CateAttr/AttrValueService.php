<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Repositories\CateAttr\AttributeRepository;
use App\Repositories\CateAttr\AttributeValueRepository;

class AttrValueService{

    /**
     * @var AttributeValueRepository
     */
    protected $attrvalue;

    /**
     * @var AttributeRepository
     */
    protected $attribute;


    /**
     * GoodsController constructor.
     *
     * @param AttributeValueRepository $attrvalue
     */
    public function __construct(AttributeValueRepository $attrvalue,AttributeRepository $attribute)
    {
        $this->attrvalue = $attrvalue;
        $this->attribute = $attribute;
    }


    public function getAttributeValueRepository()
    {
        return $this->attrvalue;
    }

    public function getAttributeRepository()
    {
        return $this->attribute;
    }



}