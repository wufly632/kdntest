<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 15:05
 */

namespace App\Repositories\ElasticSearch;

use App\Services\CLogger;
use Carbon\Carbon;
use Elasticsearch;
use Illuminate\Support\Facades\DB;

class ElasticSearchRepository
{
    const INDEX_NAME_WEBSITE_ORIGIN_CATEGORY_PRODUCTS = 'es_category_products';

    public $client ;

    protected $logger;

    protected $host;

    public function __construct($host = null)
    {
        if (!$host) {
            $host = env('ES_HOST', 'localhost');
        }
        $this->host = [$host];
        $this->client = $this->buildClient();
        $this->logger = CLogger::getLogger('import-data-to-es');
    }

    public function setClient($host = null)
    {
        if (!$host) {
            $host = env('AWS_ES_HOST');
        }
        $this->host = [$host];
//        $this->aws_key = env('AWS_KEY');
//        $this->aws_secret = env('AWS_SECRET');
//        $this->region = env('AWS_REGION');
        $this->client = $this->buildClient();
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * 创建es的client链接；ps：亚马逊es的host，后面必须加上端口
     * @return Elasticsearch\Client
     */
    private function buildClient()
    {
        try {
            $client = Elasticsearch\ClientBuilder::create()->setHosts($this->host)->build();
            return $client;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * 获取映射的参数
     * @param $index_name
     * @return array
     */
    private function getMappingParams($index_name)
    {
        $params = [
            'index' => $index_name,
            'body' => [
                'settings' => [
                    //es默认分片的最大记录是10000，若数据量大于10000，将无法分页到10000后的数据，需要把max_result_window设置得更大
                    'max_result_window' => 100000,
                ],
                'mappings' => [
                    'product' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'product_name' => [
                                'type' => 'string',
                                'analyzer' => 'english'
                            ],
                            'product_search_name' => [
                                'type' => 'string',
                                'analyzer' => 'english'
                            ],
                            //es5.0的版本以上如果需要聚合的字段，需要把fielddata这个值设置成true，要不然在搜索时聚合参数会报错
                            'option_value' => [
                                'type' => 'string',
                                'analyzer' => 'standard',
                                'fielddata' => true
                            ],
                            //es5.0的版本以上如果需要聚合的字段，需要把fielddata这个值设置成true，要不然在搜索时聚合参数会报错
                            'is_sale' => [
                                'type' => 'string',
                                'fielddata' => true
                            ],
                            //es5.0的版本以上如果需要聚合的字段，需要把fielddata这个值设置成true，要不然在搜索时聚合参数会报错
                            'product_leaf_category_id' => [
                                'type' => 'string',
                                'fielddata' => true
                            ],
                            'sell_price' => ['type'=>'double'],
                            'event_price' => ['type'=>'double'],
                            'store_price' => ['type'=>'double'],
                            'discounts' => ['type'=>'double'],
                            'event_id' => ['type'=>'integer'],
                            'product_id' => ['type'=>'integer'],
                            'recommendation_score' => ['type'=>'integer'],
                            'recommendation_robot_score' => ['type'=>'integer'],
                            'created_at' => ['type'=>'date', 'format'=>'yyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis'],
                            'updated_at' => ['type'=>'date', 'format'=>'yyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis'],
                            'size_option_value' => [
                                'type' => 'string',
                                'fielddata' => true
                            ],
                            'is_config_product' => [//是否配置的推荐商品
                                'type' => 'long'
                            ],
                            'product_status' => [
                                'type'=>'text'
                            ],
                            'mul_images' => [
                                'type'=>'text'
                            ],
                            'is_sale_ims_stock' => [//是否只卖现货商品
                                'type' => 'long'
                            ],
                            'region_price' => [
                                'type' => 'double'
                            ],
                            'product_region' => [
                                'type' => 'integer'
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return $params;
    }

    /**
     * 创建es映射，对应properties主要是用作搜索等作用
     * @param $index
     * @param bool $force
     * @return array
     */
    public function createMapping($index, $force = false)
    {
        $index_name =  $index;
        $indexParams['index']  = $index_name;
        if($this->client->indices()->exists($indexParams) && !$force) {
            return ['status' => false ];
        }

        if($force){
            //先把原来的索引删除，否则会创建失败
            $this->indexDelete($index);
        }

        $params = $this->getMappingParams($index_name);
        $this->client->indices()->create($params);
        return ['status' => true];
    }

    /**
     * 更新对应的es索引的mapping
     * @param $index
     */
    public function putMapping($index)
    {
        $params = [
            'index' => $index,
        ];
        $is_exist = $this->client->indices()->exists($params);
        if (!$is_exist) {
            $params = $this->getMappingParams($index);
            $this->client->indices()->create($params);
        } else {
            $params['type'] = 'product';
            $mapping = $this->client->indices()->getMapping($params);
            $mapping_data = [];
            if ($mapping) {
                $old_mappings = $this->getMappingParams($index);
                if ($old_mappings) {
                    $mapping_data = [
                        'index' => $params['index'],
                        'type' => $params['type'],
                        'update_all_types' => true,
                        'body' => [
                            $params['type'] => [
                                '_source' => [
                                    'enabled' => true
                                ],
                                'properties' => [
                                    'product_name' => [
                                        'type' => 'string',
                                        'analyzer' => 'english'
                                    ],
                                    'product_search_name' => [
                                        'type' => 'string',
                                        'analyzer' => 'english'
                                    ],
                                    'keyword' => [
                                        'type' =>'string'
                                    ],
                                    //es5.0的版本以上如果需要聚合的字段，需要把fielddata这个值设置成true，要不然在搜索时聚合参数会报错

                                    'option_value' => [
                                        'type' => 'string',
                                        'analyzer' => 'standard',
                                        'fielddata' => true
                                    ],
                                    //es5.0的版本以上如果需要聚合的字段，需要把fielddata这个值设置成true，要不然在搜索时聚合参数会报错
                                    'is_sale' => [
                                        'type' => 'string',
                                        'fielddata' => true
                                    ],
                                    //es5.0的版本以上如果需要聚合的字段，需要把fielddata这个值设置成true，要不然在搜索时聚合参数会报错
                                    'product_leaf_category_id' => [
                                        'type' => 'string',
                                        'fielddata' => true
                                    ],
                                    'size_option_value' => [
                                        'type' => 'string',
                                        'fielddata' => true
                                    ],
                                    'is_config_product' => [//是否配置的商品
                                        'type' => 'long'
                                    ],
                                    'product_status' => [
                                        'type'=>'text'
                                    ],
                                    'mul_images' => [
                                        'type'=>'text'
                                    ],
                                    'is_sale_ims_stock' => [//是否只卖现货商品
                                        'type' => 'long'
                                    ],
                                    'region_price' => [
                                        'type' => 'double'
                                    ],
                                    'product_region' => [
                                        'type' => 'integer'
                                    ],
                                ]
                            ]
                        ]
                    ];
                }
            }
            if ($mapping_data) {
                return $this->client->indices()->putMapping($mapping_data);
            }
        }
    }

    public function putSetting($index)
    {
        $params = [
            'index' => $index,
        ];
//        $params['type'] = 'product';
        $setting = $this->client->indices()->getSettings($params);
        $setting_data = [];
        if ($setting) {
            $setting_data = [
                'index' => $index,
                'body' => [
                    'settings' => [
                        //es默认分片的最大记录是10000，若数据量大于10000，将无法分页到10000后的数据，需要把max_result_window设置得更大
                        'max_result_window' => 100000,
                    ],
                ]
            ];
        }
        if ($setting_data) {
            $this->client->indices()->putSettings($setting_data);
        }
    }


    public function batchUpdateSpecifyColumns($product_id, $index_name, &$params)
    {
        $params['body'][] = [
            'update' => [
                '_index' => $index_name,
                '_type' => 'product',
                '_id' => $product_id,
                '_retry_on_conflict' => 3
            ]
        ];
        $params['body'][] = [
            'doc' => [
                'recommend_score' => 0,
            ]
        ];
        $this->logger->info('package product ' . $product_id . " to params! es index is " . $index_name);
    }

    public function bulkToSpecifyIndex($params)
    {
        $this->client->bulk($params);
    }


    /**
     * 根据关键字到es服务进行搜索
     * @param $keyword
     * @return array
     */
    public function dataSearch($keyword)
    {
        $search_params = [
            'keyword' => $keyword,
        ];
        $data = $this->search($search_params);
        return $data;
    }

    /**
     * 组装参数进行搜索
     * @param $search_params
     * @return array
     */
    private function search($search_params)
    {
        $option = $search_params;
        $params = $this->getQueryArray($search_params);
        //进行聚合统计搜索
        if (isset($option['group_count']) && $option['group_count']) {
            foreach ($option['group_count'] as $item) {
                $params['body']['aggs'][$item] = ['terms' => ['field' => $item, 'size' => 0]];
            }
        }
        $products = [];
        //请求搜索
        $response = $this->client->search($params);
        foreach ($response['hits']['hits'] as $kye => $item) {
            $products[] = $this->packageData($item);
        }
        return $products;
    }

    /**
     * 组装es搜索的参数
     * @param $option
     * @return array
     */
    private function getQueryArray($option)
    {
    //搜索参数
        $params = [
            'index' => $this->getIndexName(),
            'type' => 'product',
            'body' => [
                'query' => [],
            ],
            'client' => [
                'curl' => [
                    CURLOPT_CUSTOMREQUEST => 'POST'
                ]
            ],
            '_source' => [
                '_id',
                'product_id',
                'option_value',
                'product_name',
                'event_price',
                'msrp',
                'event_stock',
                'brand',
                'icon',
                'description',
                "star_level",
                "as newest",
                "recommend_score",
                "robot_weight",
                "event_id",
                "saving",
                "newest",
                "robot_weight",
                "color",
                "is_multiple",
                "color_sell_count",
                "event_type"
            ],
        ];

        $query = [];
        //关键字搜索
        if(isset($option['keyword']) && $option['keyword']) {
            $query['bool']['must'][] = ['match' => ['product_search_name'=> $option['keyword']]];
        }

        //分类ID匹配
        if(isset($option['store_category_id']) && $option['store_category_id']) {
            $query['bool']['must'][] = ['match' => [
                'store_category_id' => [
                    'query' => $option['store_category_id'],
                ]
            ]];
        }

        //筛选指定分类产品
        if (isset($option['category']) && !empty($option['category'])) {
            $category_id = $option['category'];
            if (!is_array($category_id)) {
                $category_id = array($category_id);
            }
            $category_id_str = implode(' ', $category_id);
            $query['bool']['must'][] = ['match' => [
                'product_category_id' => [
                    'query' => $category_id_str,
                    'minimum_should_match' => '100%',
                ]
            ]];
        }

        //按照属性组过滤
        if(isset($option['option_group']) && $option['option_group']) {
            foreach($option['option_group'] as $item) {
                if(!$item) {
                    continue;
                }
                $option_str = implode(' ', $item);
                $query['bool']['must'][] = ['match' => [
                    'option_value' => [
                        'query' => $option_str,
                        'minimum_should_match' => floor(100 / count($item)) . '%',
                    ]
                ]];
            }
        }

        $price_filter = [];
        if (isset($option['start_price']) && !empty($option['start_price'])) {
            $price_filter['gte'] = $option['start_price'];
        }
        if (isset($option['end_price']) && !empty($option['end_price'])) {
            $price_filter['lte'] = $option['end_price'];
        }
        if ($price_filter) {
            $query['bool']['must'][] = [
                'range' => [
                    'sell_price' => $price_filter,
                ]
            ];
        }

        //匹配带活动的数据
        if (isset($option['is_sale'])) {
            $query['bool']['must'][] = ['match' => [
                'is_sale' => [
                    'query' => $option['is_sale'],
                ]
            ]];
        }

        //添加最小匹配限制使或生效
        if (count(isset($query['bool']['should']) ? $query['bool']['should'] : []) > 0) {
            $query['bool']['minimum_should_match'] = floor(((isset($query['bool']['must']) ? count($query['bool']['must']) : 0) + 1) * 100 / (count($query['bool']['must']) + count($query['bool']['should']))) . '%';
        }

        //组合参数
        $params['body']['query'] = $query;

        return $params;
    }

    /**
     * 获取索引名称：测试用
     * @return string
     */
    private function getIndexName()
    {
        return 'es_product_en';
    }

    /**
     * 组装es返回的数据
     * @param $es_data
     * @return array
     */
    public function packageData($es_data)
    {
        try {
            $product = [
                "product_id" => $es_data['_source']['product_id'],
                "product_name" => $es_data['_source']['product_name'],
                'event_price' => $es_data['_source']['event_price'],
                'msrp' => $es_data['_source']['msrp'],
                'event_stock' => $es_data['_source']['event_stock'],
                'brand' => isset($es_data['_source']['brand']) ? $es_data['fields']['brand'] : null,
                'icon' => $es_data['_source']['icon'],
                'description' => $es_data['_source']['description'],
                "star_level" => $es_data['_source']['star_level'],
                "newest" => isset($es_data['_source']['newest']) ? $es_data['fields']['newest'] : \Carbon\Carbon::now()->toDateTimeString(),
                "recommend_score" => $es_data['_source']['recommend_score'],
                "robot_weight" => $es_data['_source']['robot_weight'],
                "color" => $es_data['_source']['color'],
                "event_id" => $es_data['_source']['event_id'],
                "saving" => $es_data['_source']['saving'],
                "is_multiple" => $es_data['_source']['is_multiple'],
                "color_sell_count" => $es_data['_source']['color_sell_count'],
                "es_unique_id" => $es_data['_id'],
                "event_type" => isset($es_data['_source']['event_type']) ? $es_data['fields']['event_type'] : 0,
                "es_id" => $es_data['_id']
            ];
            return $product;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * 根据es中保存的id强制删除es上的数据
     * @param $index_name
     * @param $type
     * @param $id
     * @return bool
     */
    public function forceDelete($index_name, $type, $id)
    {
        $params = [
            'index' => $index_name,
            'type' => $type,
            'id' => $id,
        ];
        if ($this->client->exists($params)) {
            $this->client->delete($params);
            return true;
        } else {
            return false;
        }
    }


    public function importHotWords($hot_word, $index_name)
    {
        $words = strtolower($hot_word->words);
        $params = [
            'index' => $index_name,
            'type' => 'words',
            'id' => $words,
            'body' => [
                'nums' => $hot_word->caculate,
                'words' => $words,
                'count' => $hot_word->count
            ]
        ];
        $this->client->index($params);
    }

    public function indexDelete($index)
    {
        $params = ['index' => $index];
        $response = $this->client->indices()->delete($params);
        return $response;
    }

}