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
            $data[$key]['removed'] = [];
        }
        return $data;
    }

    public function delete($id)
    {
        $this->mobileCategoryRepository->delete($id);
        $this->mobileCategoryRepository->model()::where('parent_id', $id)->delete();
    }

    public function updateOrCreate($item)
    {
        $data = $item;
        if ($item['id']) {
            $parentCategory = $item;
            $this->mobileCategoryRepository->model()::where('id', $item['id'])->update([
                'name' => $item['name'],
                'category_id' => $item['category_id'],
                'icon' => $item['icon'],
                'sort' => $item['sort']
            ]);
        } else {
            $parentCategory = $this->mobileCategoryRepository->model()::create([
                'name' => $item['name'],
                'category_id' => $item['category_id'],
                'icon' => $item['icon'],
                'sort' => $item['sort']
            ])->toArray();
        }
        if ($item['removed']) {
            $removedChilds = $this->idFilter($item['removed']);
            $this->mobileCategoryRepository->model()::whereIn('id', $removedChilds)->delete();
        }
        if ($item['child']) {
            foreach ($item['child'] as $key => $child) {
                if ($child['id']) {
                    $this->mobileCategoryRepository->model()::where('id', $child['id'])->update(
                        [
                            'name' => $child['name'],
                            'parent_id' => $parentCategory['id'],
                            'category_id' => $child['category_id'],
                            'image' => $child['image'],
                            'sort' => $child['sort']
                        ]);
                } else {
                    $childModel = $this->mobileCategoryRepository->model()::create(
                        [
                            'name' => $child['name'],
                            'parent_id' => $parentCategory['id'],
                            'category_id' => $child['category_id'],
                            'image' => $child['image'],
                            'sort' => $child['sort']
                        ]
                    );
                    $data['child'][$key]['id'] = $childModel->id;
                }

            }
        }
        $data['id'] = $parentCategory['id'];
        $data['removed'] = [];
        return $data;
    }

    public function idFilter(Array $ids)
    {
        $filteredId = [];
        foreach ($ids as $id) {
            if ($id != '') {
                array_push($filteredId, $id);
            } else {
                continue;
            }
        }
        return $filteredId;
    }


}