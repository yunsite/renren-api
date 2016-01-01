# Introduction #

由于renren-api php版的比较多人在使用，近期也发现很多Developers咨询同一样的问题，所以我总结了一下，并把内容整理发到renren-api的wiki中，且持续更新。

各位在进行人人网APP开发之前，请先认真了解一些常见的问题，这可以帮助你更快更有效的开发应用程序。


# Details #
## 1、为什么获取不了Session key ##

1.1、用于测试的域名是否在外网能正常访问？不能使用如localhost等只用于本机测试的域名，因为使用“人人网连接”登录之后，人人网的服务器会进行callback，如果发现不能连接目标服务器，则不会生成Cookies，即没有生成Session key;

1.2、另外要把人人网用于跨域的文件放置在你的APP的根目录下，名称为：xd\_receiver.html，更具体的设置方法请到人人网的API查看：http://wiki.dev.renren.com/wiki/API

## 2、Sig验证失败 ##
引起这个问题的原因有几个：

2.1、需要先从人人网申请到API Key(API的代号)以及Secret(密钥);

2.2、参数是否齐全？此步很关键，需要确认是否正确配置renren-api php版的config.inc.php文件，规则如下：

接口内容来自：http://wiki.dev.renren.com/wiki/API

编写时请遵守以下规则：

key  (键名)	: API方法名，直接Copy过来即可，请区分大小写

value(键值): 把所有的参数，包括required(必须)及optional(可选)，除了api\_key,method,v,format不需要填写之外，其它的都可以根据你的实现情况来处理，以英文半角状态下的逗号来分割各个参数。

2.3、确保正常援权，即获取用户当前登录状态下的Session key，上述中已经提过获取Session key的注意事项，只有正确获取到Session key才能调用到人人网的RESTful api，

## 3、如何获取callback或remove信息 ##
首先你必须要在人人网开放平台的“我的应用”栏目中设置好你的callback(授权回调地址)以及remove(移除后回调地址)等信息。

人人网的服务器返回分为几种情况：

3.1、首次援权返回，即授权回调地址，服务器会以POST方式返回数据，只返回一次，所以首次你必须要把数据都接受回来，并把相关的ID存放到你的数据库中，以便以后做关联，但是，偶尔人人网的服务器也不会返回这个数据，可能是有延时关系，在这种情况下，用户已经登录了，所以，你必须要有容错机制，即获取他们的ID，因为这个是存放到你本地的Cookies当中，格式为：YOUR-API-KEY\_user，当有这些值存在，证明有人人网用户登录了你的系统且已授权通过，因此，你可以将其保存到你的数据库;

3.2、Canvas Callback，即每次正常登录，并不是首次的时候都会以Canvas Callback的方式来返回数据，服务器是以GET的方式来回传数据的，格式如下：

```
Array
(
    [action] => info
    [origin] => 103
    [xn_sig_method] => get
    [xn_sig_time] => 1290571284486
    [xn_sig_user] => 346132863
    [xn_sig_expires] => 1290578400
    [xn_sig_session_key] => 2.9094baebd39d660ee345fbda44ce60c7.3600.1290578400-346132863
    [xn_sig_added] => 1
    [xn_sig_api_key] => c656ef79f8994071aaa7efafdc189185
    [xn_sig_app_id] => 121098
    [xn_sig_domain] => renren.com
    [xn_sig_user_src] => rr
    [xn_sig] => ebd53a8e0d9d9c815c81d50709c01d51
);
```

3.3、用户删除应用，当用删除之后，服务器会以POST的格式返回数据，格式如下：

```
Array
(
    [userId] => 346132863
    [xn_sig_uninstall] => 1
    [xn_sig_user] => 346132863
    [xn_sig_app_id] => 121098
    [xn_sig_time] => 1303960280618
    [xn_sig_added] => 0
    [xn_sig_method] => POST
    [xn_sig_api_key] => c656ef79f8994071aaa7efafdc189185
    [xn_sig] => 1937c7111f3228cc9bbfc2d08fcd8b4a
);
```

持续更新...