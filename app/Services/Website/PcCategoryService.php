<?php

namespace App\Services\Website;

use App\Repositories\Website\PcCategoryRepository;

class PcCategoryService
{
    protected $pcCategoryRepository;

    public function __construct(PcCategoryRepository $pcCategoryRepository)
    {
        $this->pcCategoryRepository = $pcCategoryRepository;
    }

    public function get()
    {
        $field = ['id', 'category_id', 'name', 'sort', 'parent_id'];
        $levelone = $this->pcCategoryRepository->orderBy('sort', 'desc')->findWhere(['parent_id' => 0], $field);
        $ids = array_pluck($levelone, 'id');
        $levelTwo = $this->pcCategoryRepository->orderBy('sort', 'desc')->findWhereIn('parent_id', $ids, $field);
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
        $this->pcCategoryRepository->delete($id);
        $this->pcCategoryRepository->model()::where('parent_id', $id)->delete();
    }

    public function updateOrCreate($item)
    {
        $data = $item;
        if ($item['id']) {
            $parentCategory = $item;
            $this->pcCategoryRepository->model()::where('id', $item['id'])->update([
                'name' => $item['name'],
                'category_id' => $item['category_id'],
                'sort' => $item['sort']
            ]);
        } else {
            $parentCategory = $this->pcCategoryRepository->model()::create([
                'name' => $item['name'],
                'category_id' => $item['category_id'],
                'sort' => $item['sort']
            ])->toArray();
        }
        if ($item['removed']) {
            $removedChilds = $this->idFilter($item['removed']);
            $this->pcCategoryRepository->model()::whereIn('id', $removedChilds)->delete();
        }
        if ($item['child']) {
            foreach ($item['child'] as $key => $child) {
                if ($child['id']) {
                    $this->pcCategoryRepository->model()::where('id', $child['id'])->update(
                        [
                            'name' => $child['name'],
                            'parent_id' => $parentCategory['id'],
                            'category_id' => $child['category_id'],
                            'sort' => $child['sort']
                        ]);
                } else {
                    $childModel = $this->pcCategoryRepository->model()::create(
                        [
                            'name' => $child['name'],
                            'parent_id' => $parentCategory['id'],
                            'category_id' => $child['category_id'],
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