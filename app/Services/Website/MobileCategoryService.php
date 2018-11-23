<?php


namespace App\Services\Website;


use App\Repositories\Website\MobileCategoryRepository;

class MobileCategoryService
{
    protected $mobileCategoryRepository;

    public function __construct(MobileCategoryRepository $mobileCategoryRepository)
    {
        $this->mobileCategoryRepository = $mobileCategoryRepository;
    }

    public function get()
    {
        $field = ['id', 'category_id', 'name', 'image', 'icon', 'sort', 'parent_id'];
        $levelone = $this->mobileCategoryRepository->orderBy('sort', 'desc')->findWhere(['parent_id' => 0], $field);
        $ids = array_pluck($levelone, 'id');
        $levelTwo = $this->mobileCategoryRepository->orderBy('sort', 'desc')->findWhereIn('parent_id', $ids, $field);
        $data = [];
        foreach ($levelone as $key => $item) {
            $data[$key] = $item;
            $child = [];
            foreach ($levelTwo as $value) {
                if ($value->parent_id == $item->id) {
                    array_push($child, $value);
                }
            }
            $data[$key]['child'] = $child;
            $data[$key]['show'] = false;
        }
        return $data;
    }
}