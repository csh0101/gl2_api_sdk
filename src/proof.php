
<?php

require_once '/Users/csh0101/work/gl2_api_sdk/src/GL2APIUtils.php';

use Nears\Gl2ApiSdk\GL2APIUtils;

// 模拟环境变量设置
putenv('GL2_WHITELIST_API_HOST=http://localhost:8082');
//putenv('AUTHORIZATION=Basic your_token');


// 初始化
GL2APIUtils::init();

// 使用示例参数调用方法
$app = 'nc.cli.im';
$uri = '/task/getTargetQrcodeTaskMsg';

// 使用cURL方法测试
//$resultCurl = GL2APIUtils::verifyURIWithCurl($app, $uri);
//echo "Result using cURL: " . ($resultCurl ? 'true' : 'false') . PHP_EOL;

// 使用file_get_contents方法测试
$resultFileGetContents = GL2APIUtils::verifyURIWithFileGetContents($app, $uri);
echo "Result using file_get_contents: " . ($resultFileGetContents ? 'true' : 'false') . PHP_EOL;
