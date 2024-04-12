<?php

namespace Nears\Gl2ApiSdk;
class GL2APIUtils {
    // 静态成员变量
    public static $apiHost;
    public static $authorization;

    public static function init($apiHost,$authorization) {
        self::$apiHost = $apiHost;
        self::$authorization = $authorization;
    }

    // 使用cURL发送请求，并根据响应返回布尔值
    public static function verifyURIWithCurl($app, $uri) {
        self::$apiHost = getenv('GL2_WHITELIST_API_HOST');
        self::$authorization = getenv('AUTHORIZATION');
        $url = self::$apiHost . "/api/uri/app_uri/verify?app=" . urlencode($app) . "&uri=" . urlencode($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: " . self::$authorization
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            // 如果有cURL错误，我们认为验证失败
            return false;
        }

        curl_close($ch);
        $response = json_decode($result, true); // 将结果转换为数组

        // 检查"data"字段是否为true
        return isset($response['data']) && $response['data'] === true;
    }

    // 使用file_get_contents发送请求，并根据响应返回布尔值
    public static function verifyURIWithFileGetContents($app, $uri) {
        self::$apiHost = getenv('GL2_WHITELIST_API_HOST');
        self::$authorization = getenv('AUTHORIZATION');
        $url = self::$apiHost . "/api/uri/app_uri/verify?app=" . urlencode($app) . "&uri=" . urlencode($uri);

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Authorization: " . self::$authorization,
            ],
        ]);

        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true); // 将结果转换为数组

        // 检查"data"字段是否为true
        return isset($response['data']) && $response['data'] === true;
    }
}
