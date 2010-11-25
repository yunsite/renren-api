<?php
/*
 * 调用人人网RESTful API的范例，本类需要继承RESTClient类方可使用
 * 要求最低的PHP版本是5.2.0，并且还要支持以下库：cURL, Libxml 2.6.0
 * This example for invoke RenRen RESTful Webservice
 * It MUST be extends RESTClient
 * The requirement of PHP version is 5.2.0 or above, and support as below:
 * cURL, Libxml 2.6.0
 *
 * @Version: 0.0.1 alpha
 * @Created: 0:11:39 2010/11/25
 * @Author:	Edison tsai<dnsing@gmail.com>
 * @Blog:	http://www.timescode.com
 * @Link:	http://www.dianboom.com
 */

require_once 'RenRenClient.class.php';

$rrObj = new RenRenClient;

/*
 *@获取指定用户的信息
 *@POST暂时有两个参数，第一个是需要调用的方法，具体的方法跟人人网的API一致，注意区分大小写
 *@第二个参数是一维数组，顺序排列必须跟config.inc.php文件中的$config->APIMapping设置一样，否则会出现异常
 */
$res = $rrObj->POST('users.getInfo', array('12345678','346132863,741966903','uid,name,tinyurl,headhurl,zidou,star'));
print_r($res);
?>