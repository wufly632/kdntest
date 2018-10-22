<?php
/**
 * Created by PhpStorm.
 * User: rogers
 * Date: 18-10-20
 * Time: 下午5:14
 */

namespace Tests\Feature;


use App\Repositories\Website\BannerRepository;
use Carbon\Carbon;
use Tests\TestCase;

class BannerRepositoryTest extends TestCase
{
    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }
}