<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 15:04
 */

namespace App\Modules\ElasticSearch\Services;

use App\Repositories\ElasticSearch\ElasticSearchRepository;


class ElasticSearchService
{
    protected $elasticSearchRepository;

    public $client;

    public function __construct(ElasticSearchRepository $elasticSearchRepository)
    {
        $this->elasticSearchRepository = $elasticSearchRepository;
        $this->client = $elasticSearchRepository->client;
    }

    public function setClient($host = null)
    {
        $this->elasticSearchRepository->setClient($host);
    }

    public function getClient()
    {
        return $this->elasticSearchRepository->getClient();
    }

    public function createMapping($index, $force = false)
    {
        return $this->elasticSearchRepository->createMapping($index, $force);
    }

    public function putMapping($index)
    {
        return $this->elasticSearchRepository->putMapping($index);
    }

    public function putSetting($index)
    {
        $this->elasticSearchRepository->putSetting($index);
    }

    public function batchUpdateSpecifyColumns($product_id, $index, &$params)
    {
        $this->elasticSearchRepository->batchUpdateSpecifyColumns($product_id, $index, $params);
    }

    public function dataSearch($keyword)
    {
        return $this->elasticSearchRepository->dataSearch($keyword);
    }

    public function forceDelete($index_name, $type, $id)
    {
        return $this->elasticSearchRepository->forceDelete($index_name, $type, $id);
    }

    public function indexDelete($index_name)
    {
        return $this->elasticSearchRepository->indexDelete($index_name);
    }

    public function importHotWords($hot_words, $index_name)
    {
        $this->elasticSearchRepository->importHotWords($hot_words, $index_name);
    }

}