<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/12/4 下午7:25
 */
namespace App\Console\Commands\Product\Indices;

use Illuminate\Support\Facades\Artisan;

class ProjectIndex
{
    public static function getAliasName()
    {
        return 'waiwaimall_products';
    }

    public static function getProperties()
    {
        return [
            'type'          => ['type' => 'keyword'],
            'good_en_title' => ['type' => 'text'],
            'good_en_summary'=> ['type' => 'text'],
            'category_id'   => ['type' => 'integer'],
            'category_ids'  => ['type' => 'keyword'],
            'category_path' => ['type' => 'text'],
            'price'         => ['type' => 'scaled_float', 'scaling_factor' => 100],
            'status'        => ['type' => 'integer'],
            'good_stock'    => ['type' => 'integer'],
            'orders'        => ['type' => 'integer'],
            'new'           => ['type' => 'date', 'format' => 'yyyy-mm-dd hh:mm:ss'],
            'main_pic'      => ['type' => 'text'],
            'skus'          => [
                'type'       => 'nested',
                'properties' => [
                    'good_stock'       => [
                        'type'            => 'text',
                        'copy_to'         => 'skus_title',
                    ],
                    'description' => [
                        'type'     => 'text',
                        'copy_to'  => 'skus_description',
                    ],
                    'price'       => ['type' => 'scaled_float', 'scaling_factor' => 100],
                ],
            ],
            'properties'    => [
                'type'       => 'nested',
                'properties' => [
                    'name'         => ['type' => 'keyword'],
                    'value'        => ['type' => 'keyword', 'copy_to' => 'properties_value'],
                    'search_value' => ['type' => 'keyword'],
                ],
            ],
        ];
    }

    public static function getSettings()
    {
        return [
            'analysis' => [
                'analyzer' => [

                ],
                'filter'   => [
                    'synonym_filter' => [
                        'type'          => 'synonym',
                        'synonyms_path' => 'analysis/synonyms.txt',
                    ],
                ],
            ],
        ];
    }

    public static function rebuild($indexName)
    {
        // 通过 Artisan 类的 call 方法可以直接调用命令
        // call 方法的第二个参数可以用数组的方式给命令传递参数
        Artisan::call('sync:elasticsearch', ['--index' => $indexName]);
    }
}