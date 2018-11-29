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
                                    'product_leaf_category_id' => [
                                        'type' => 'string',
                                        'fielddata' => true
                                    ],
                                    'size_option_value' => [
                                        'type' => 'string',
                                        'fielddata' => true
                                    ],
                                    'product_status' => [
                                        'type'=>'text'
                                    ],
                                    'mul_images' => [
                                        'type'=>'text'
                                    ],
                                    'region_price' => [
                                        'type' => 'double'
                                    ]
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

    /**
     * 往es的索引添加指定的商品数据
     * @param string $index_name
     * @param int $product_id
     * @param array $other_params 作为扩展其他传递参数的字段，如果有自己的扩展， 请在以下格式添加自己的参数
     * 格式：[
     *      'recommend_products' => ['product_id1' => {xxx=xxx,..}]，  //array 以商品ID作为数组key的对象数组
     *      'xxx' => xxxx,//请自行扩展
     * ]
     *
     * @throws \Exception
     */
    public function importDataToSpecifyIndex($index_name,$product_id, $other_params = [], $version = 1)
    {
        //获取产品信息
        $client = $this->client;
        $data = $this->getSearchProductRawData($product_id);

        if ($data) {
            $data = $this->checkIfMultipleColor($data);
            //填充商品属性
            $data = $this->fillProductSizeOption($data);
            if ($version == 1) {
                if ($data->product_status != 11) {
                    $this->logger->info('product ' . $data->product_id . " is offline,will not be add to es!");
                    return;
                }
            }
            $params = [
                'index' => $index_name,
                'type' => 'product',
                'id' => $data->product_id,
            ];
            //无法获取有效搜索数据则对数据进行清除
            if (!$data) {
                //进行搜索引擎数据删除操作
                try {
                    $client->delete($params);
                } catch (\Elasticsearch\Common\Exceptions\Missing404Exception $e) {
                    //IGNORE
                } catch (\Exception $e) {
                    throw $e;
                }
                return;
            }
            if ($client->exists($params)) {
                if ($version == 1) {
                    $this->logger->info('1.Delete product ' . $data->product_id . " from es with color!");
                    $client->delete($params);
                }
                $this->logger->info('Index is ' . $index_name . ', This product ' . $data->product_id . " already in es!");
                $this->updateDataToSpecifyIndex($index_name, $data->product_id, []);
                $this->logger->info('Index is ' . $index_name . ', Update product ' . $data->product_id . " already in es!");
                return;
            }
            $product_option_value_string = $this->getOptionValue($data->product_id);
//                $category_tree = $this->getProductCategoryTree($data->product_id);
            //TODO 多语言支持处理
            $category_names_string = $this->getProductCategoryString($data->product_id);
            if ($category_names_string) {
                $product_search_name = $category_names_string . ' ' . $data->product_name;
            } else {
                $product_search_name = $data->product_name;
            }
            $product_search_category_id = $this->getProductSearchCategoryId($data->product_id);
            $product_leaf_category_id = $this->getProductLeafCategoryId($data->product_id);
            $store_category_ids = $this->getStoreCategoryIds($product_search_category_id);
            $statisticsInfo = $this->getStatistics($data->product_id);
            $stock = $this->checkWhetherInStock($data);
            $mul_images = $this->getProductTplIcon($data->product_id);
            $is_sale_ims_stock = $this->checkIsImsStock($data->product_id);
            $recommendationScore = $this->getProductRecommendedScore($data->product_id);

            //分类树配置的商品
            $recommend_products = [];
            if (isset($other_params['recommend_products']) && is_array($other_params['recommend_products'])) {
                $recommend_products = $other_params['recommend_products'];
            }

//                $event_type = self::getEventType($data->event_id);
            $params = [
                'index' => $index_name,
                'type' => 'product',
                'id' => $data->product_id,
                'body' => [
                    'product_id' => $data->product_id,
                    'product_category_id' => implode(' ', $product_search_category_id), //用来做快速搜索用
                    'product_leaf_category_id' => implode(' ', $product_leaf_category_id), //用来做数据聚合搜索统计用
                    'store_category_id' => implode(' ', $store_category_ids),
                    'product_name' => $data->product_name,
                    'product_search_name' => $product_search_name,
                    'keyword' => $data->keyword,
                    'product_url' => (isset($recommend_products[$data->product_id]) && isset($recommend_products[$data->product_id]->image_url) && !empty($recommend_products[$data->product_id]->image_url)) ? $recommend_products[$data->product_id]->image_url : $data->product_url,
                    'event_price' => $data->event_id ? $data->event_price : $data->store_price,
                    'store_price' => $data->store_price,
                    'sell_price' => $data->event_id ? $data->event_price : $data->store_price,
                    'option_value' => $product_option_value_string, //option value 用来做聚合搜索， 搜索页展示option选项
                    'discounts' => floor(($data->msrp - ($data->event_id ? $data->event_price : $data->store_price)) * 100 / $data->msrp), //打折节约价格，discounts 排序用到
                    'sell_count' => isset($statisticsInfo['seven_days_sale_quantity']) ? $statisticsInfo['seven_days_sale_quantity'] : 0, //根据销售量排序
                    'review_count' => isset($statisticsInfo['product_detail_visit']) ? $statisticsInfo['product_detail_visit'] : 0, //根据商品查看量排序
//                        'color_sell_count' => $this->getProductColorSales($data->product_id,$data->color),
                    'color_sell_count' => isset($statisticsInfo['sale_quantity']) ? $statisticsInfo['sale_quantity'] : 0, //根据销售量排序
                    'msrp' => $data->msrp,
                    'updated_at' => ($data->updated_at == '0000-00-00 00:00:00') ? '2015-01-01 01:01:01' : $data->updated_at,
                    'created_at' => ($data->created_at == '0000-00-00 00:00:00') ? '2015-01-01 01:01:01' : $data->created_at, //新品排序用到
                    'recommendation_robot_score' => $data->robot_weight,
                    'in_stock' => $stock ? 1 : 0,
                    'event_stock' => $stock,
                    'brand' => $data->brand,
                    'icon' => (isset($recommend_products[$data->product_id]) && isset($recommend_products[$data->product_id]->image_url) && !empty($recommend_products[$data->product_id]->image_url)) ? $recommend_products[$data->product_id]->image_url : $data->icon,
                    'description' => $data->description,
                    "star_level" => $data->star_level,
                    "newest" => $data->newest,
                    "saving" => round(($data->msrp - $data->store_price) / $data->msrp, 2),
                    "color" => $data->color,
                    'recommendation_score' => $recommendationScore,
                    "recommend_score" => (isset($recommend_products[$data->product_id]) && isset($recommend_products[$data->product_id]->recommend_score)) ? (int)$recommend_products[$data->product_id]->recommend_score : 0,
                    "robot_weight" => $data->robot_weight,
                    "is_multiple" => $data->is_multiple,
                    'event_type' => $data->event_type,
                    'size_option_value' => isset($data->size_option_value) ? implode(';', $data->size_option_value) : '', //商品属性值
                    'product_status' => $data->product_status,
                    'is_config_product' => isset($recommend_products[$data->product_id]) ? 1 : 0,
                    'mul_images' => $mul_images,
                    'is_sale_ims_stock' => $is_sale_ims_stock,
                    'product_region' => $data->product_region,
                    'middle_east_price' => $data->middle_east_price
                ]
            ];

            //请求保存索引
            $client->index($params);
            $this->logger->info('add product ' . $data->product_id . " to es! es index is " . $index_name);
//            }
        }
    }

    /**
     * 获取指定产品搜索数据
     * @param $product_id
     * @param $language
     * @return null
     */
    public static function getSearchProductRawData($product_id,$language)
    {
        $product_id = (int)$product_id;
        $sql = <<<EOT
            SELECT oms_products.id AS product_id, oms_products.product_name AS product_name, oms_products.icon AS product_url, oms_products.icon_color AS icon_color,oms_products.recommendation_score as recommendation_score,
oms_products.msrp AS msrp, oms_products.store_price as store_price, oms_products.event_price as event_price, 0 AS event_id,0 AS event_type, '' AS event_name, updated_at, created_at,robot_weight,oms_products.brand AS brand,oms_products.icon AS icon,oms_products.description AS description,oms_products.avg_star_level AS star_level,oms_products.created_at as newest,oms_products.product_status,oms_products.middle_east_price FROM oms_products
WHERE id=$product_id
EOT;

        $products = DB::select(DB::raw($sql));
        if(!$products) {
            return null;
        }
        $product = $products[0];

        $event_ids = DB::table('oms_events')
            ->where('status', EventsStatus::ADOPTED)
            ->where('start_at', '<=', Carbon::now()->toDateTimeString())->where('end_at', '>=', Carbon::now()->toDateTimeString())
            ->lists('id');
        if ($event_ids) {
            $event_product = DB::table('oms_event_products')->where('product_id', $product_id)->where('is_hidden', 0)->whereIn('event_id', $event_ids)
                ->orderBy('event_id', 'DESC')->first();
            if ($event_product) {
                $event = DB::table('oms_events')->find($event_product->event_id);
                if ($event->type == 'FlashSale') {
                    $product->event_type = 1;
                } else {
                    $product->event_type = 2;
                }
                $product->event_id = $event_product->event_id;
                $product->event_price = $event_product->event_price;
            } else {
                $product->event_price = $product->store_price;
            }
        }
        if($language->id!=1){
            $product1 = DB::table('oms_product_name_description')->select('name','description')->where('product_id',$product_id)->where('language',$language->name)->first();
            if($product1) {
                $product->keyword = $product1->name ? $product1->name . ' ' . $product->product_name: $product->product_name;
//                $product->description = $product1->description?$product1->description:$product->description;
            } else {
                $product->keyword = $product->product_name;
            }
        } else {
            $product->keyword = $product->product_name;
        }
        $product_region = DB::table('oms_product_region_map')->where('product_id', $product_id)->where('deleted_at', null)->first();
        if ($product_region) {
            $product->product_region = (int)$product_region->region_id;
        } else {
            $product->product_region = 0;
        }

        return $product;
    }

}