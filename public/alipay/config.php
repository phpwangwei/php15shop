<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091300503588",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEA83ZJbxxnObVHFe9j0lb0rTTaLWL3LFNOLuz3UFinX9/Nw7e3taHTP8gpbfYhQpB3V+e60CfLlllXYNQewaupyToOmihDgw4X1Bzu0PyHFPIgN+g9ctvpPgh+qcgTXupkvzJidtqZSAWIvYLFF1HJBeN/AZl0PFWQTR/EiCcQRcxdB6TRopuM0XFb5MsACexESh7nyvsp+Icoi7PyZJ1P4V6hbboCerKigwwlY2Ro6eMLjsCnfD/rC1DPjNhUOggUKTEjYy+zoh/VPQEuGfKgOCayZqvr5PfGKOQzb6h2LSNRAF8cjWtCCZQ/3EdlwUUOj/F7X+D9G0WgpddJjjx+pwIDAQABAoIBAQCk2u7kru3y9J4a60vDjSAG/OfTndTTDeG+ArWAkVdcozY4lfluoxJheQ8cp3JkGWDGhGJKOvgvaXWyWlAtQiko2ggzOJpmbq+R8LmBh82MUFuin76kPObWG3hxTMpZFgx8LwjfhCwQybaK5LbCkJ23QBGrKpa7mBCrOJyiuRjauTIX12I7a47CRVbrlgwyV+9UvQiA5AG/MixrVk9syh4DMikFfI1UHJ5SaZChlB5zmZUsOLpaXaD+oA+JVlmfL7K78N5GTLSIYjq16YeCswyjMozUJEurln1hVbm5SdQPTJTVflyjG8CzbcmKsJC5qN2F1o0aQJZWi+JYJAKST1kZAoGBAPooorOJ7+LsGCEdphV7YHwTvBKGzcXqlrvJEwnRSNLXAzRvBx7/nifhXBO1w1L8XBKPf7lc78Tm9fyRMpPIGhOq3DeWX4KoeOCa9LDxs8TbNSAOQgtZqCQ1G0Bsb5Lmw3Owz9bZykVXPmkCJOvUXKdDQxGOZSWRb9y2Q0qBH10jAoGBAPklnu9Y9uv6W5f77bF2EYVfLMFgR5ymiOI5+V4xreBddH1f2806E/aOSEcCcWI3KM+CY7fcYlR8mV44m0aie8OFE+OA7OdC9QSQw6N9QCuTf2bv8NOg7PhFawE4kA05e75+YLNLM1vZ5n8ok9vWUdr0BtNb2V+EyraL4t/G5xqtAoGBAM70EzZJJUYsYAH1j1MyUK4VfYAuOcpEuxL71F5I3+BdtO8J83A3tNX1YMGFm+Pplxpb0SS+uDXDhTm/vYH5B2nB7pGmO7nSOr5GM6y3KSvw1dCBOy48rBfYP4VasCtt8cCiRC/Q2b/n31/sQDNB6q0Nvkyl6xPbcBm+R4k5rYLVAoGADl3H+18y5cqK64mgXCJFwl4Jk6D8oCDONdVH9tGAiDZ7WBtl7kCSFB6CNm4CoboyhTysiVaQ6PRCV7eF5J3L6ytKSU0O3Ar1W+0JCu1W/OxFZWciiOF3qJ1AHVLoo4qUAxkAdHY6oOpAq0ZouD10fN6jYh6iuypKEhqg22x5uQUCgYAUdJynC2v5BeUlO3Ng+2tCyuKgwtwZN2VnBP1z8cKDqknT8vK0JaSpNQ9eF22aSOeMt1wWUApLTKDXVsgiGaZ6SkwL83sN12dmT7BPIm3gkLPMQcZpTsLn32tY/0Xt5Dz8IMN/sQpIIYaXTqWuuzwI+riyd1NozeoEH5UGliNyLw==",
		
		//异步通知地址
		'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAp10G5r670h5LuSuQa1U9FQBN9EEKi9xX4pdmFelzRujd4iCkwNFsxAszFHNPrPSe5I25SAS39KghYm7uVbwBAGrcLw+FoN4o4P2hPRFmQlDXeuOgFBYwqMp0izsSgys2AKHa+TW6okw6/Ftg/0NHk9oIHU/1NqLDSdhwZhhXTdMARcBaG8s/+rnd77sJbDGhvEg60EW0dDJYkCXmYDFK5Q0tReXOCF0zYYwQAi58ijMdvYWTLkNls7b0xSLD1/MvTzw5GgmkUExHth0q4SlMy3sVSsuEtHVJUWtXeyTSjfNxOsSngS6EuD0Bb/vnMTr4xPzMdFneYDzvO71gbsuvpQIDAQAB",
);