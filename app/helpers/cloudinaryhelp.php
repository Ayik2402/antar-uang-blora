<?php

namespace App\Helpers;

use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\DB;
use Cloudinary\Configuration\Configuration;

class cloudinaryhelp
{
    public static function cloudinarys()
    {
        $config = new Configuration();
        $cloudName = 'df4tfdsc6';
        $apiKey = '465389711284399';
        $apiSecret = 'Z1URQ59PVWQWBcJ_uEJe-dAxRic';

        $config->cloud->cloudName = $cloudName;
        $config->cloud->apiKey = $apiKey;
        $config->cloud->apiSecret = $apiSecret;
        $config->url->secure = true;
        $cloudinary = new Cloudinary($config);

        return $cloudinary;
    }
}
