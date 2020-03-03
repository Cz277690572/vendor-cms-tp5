<?php
/**
 * 自定义配置文件(非框架自带)
 */
return [
	// 小程序app_id
	'app_id' => 'wxcbba84a3171a22ca',
	// 小程序app_secret
	'app_secret' => '273208ce1092a31d1a1c89f5a71e1fc7',
	// 微信使用code换取用户openid及session_key的url地址
	'login_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
	// 微信获取access_token的url地址
	'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" . 
		"grant_type=client_credential&appid=%s&secret=%s",
];