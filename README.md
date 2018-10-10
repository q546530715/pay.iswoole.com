# Alipay
PHP支付宝免签接口,2018不掉单免签支付二维码接口、APP支付宝监控、PC监控、云端监控（运营版）


玩法：
1.开户，收取开户费，后台添加会员，设置费率
2、服务版，提供通道，用户直接使用平台帐户，钱到平台，T+N到帐，后扣手续费
3、公开版，商户自行收款，钱直接到商户帐号，需要预存手续费。

更新日志：

09-23修复ZFB协议，商家码并发多单成功一单bug（全网独家修复）bug
09-29增加pc监控，保证在少通道高流量下导致的百分百回调。
10-02APP增加本地数据库，优化回调方案
10-03服务端优化轮询算法，到账更均匀

下版本功能预告：

1.增加静态码，项目动静码结合，减少APP生成码的操作，预存二维码，提升更高的并发量以及用户请求码的返回速度

2.增加批量生成二维码，预批量上传二维码，保证动态码官方更新导致无法生成码的预备方案。

亮点功能：轮循，商户，代理，后台多模块设置，稳定不掉单。市面上的玩法，该套系统该有的都有。


团队提供完整源码，可提供技术合作服务，提供跑量测试，提供架构服务，可解决系统中在运营过程中任何问题，可技术合伙入股。

联系QQ：858887906
联系VX：liang546530715

测试地址：http://pay.iswoole.com
管理地址：联系获取

# 用法

config.php修改如下内容。

    //数据库操作方式
	define('DB_TYPE', 'pdo');
	//主机地址
	define('DB_HOST', '127.0.0.1');
	//数据库名称
	define('DB_NAME', 'pay_iswoole_com');
	//数据库账号
	define('DB_USER', 'pay_iswoole_com');
	//数据库密码
	define('DB_PWD', '123456');
	//数据库端口
	define('DB_PORT', 3306);
	//数据库编码
	define('DB_CHAR', 'utf8');
	//数据库前缀
	define('DB_PREFIX', 'xh_');
	//软件版本号
	define('SYSTEM_VERSION', 'v1.1');
	//网站名称
	define('WEB_NAME', '老牛支付');
	//联系手机号码
	define('WEB_MOBILE', '15017399443');
	//联系QQ
	define('WEB_QQ', '858887906');
	//Redis配置
	define("REDIS_ENABLE", true);
	define("REDIS_PORT", 6379);
	define("REDIS_HOST", '127.0.0.1');
	define("REDIS_AUTH", '');



# 对接说明
1、本插件会用curl发送POST请求到你设定的通知地址。
### POST字段说明
    
    time 转账时间
    title  转账的说明
    trade 支付宝交易号（流水号）
    name 打款人
    amount 转账金额
    sig 密钥（大写的MD5加密后的字符串）

### 返回字符
如果通知成功请返回success字符。

# License
http://pay.iswoole.com

