<?php

session_start();
$csrf_key = md5(time(). 'key');
$_SESSION['csrf_key'] = $csrf_key;
setcookie('csrf_key', $csrf_key,time()+60*5, '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>This is title</title>
    <meta content="always" name="referrer">
    <meta name="Keywords" content="Keywords">
    <meta name="copyright" content="ishangweb.com">
    <meta name="Description" content="Description">
    <meta name="author" content="http://www.ishangweb.com" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />
    <meta name="mobile-agent" content="format=html5;url=http://m.ishangweb.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel='stylesheet' id='arcade-basic-fonts-css'  href='//fonts.googleapis.com/css?family=Megrim|Raleway|Open+Sans:400,400italic,700,700italic' type='text/css' media='all' />
</head>
<body>
<span class="login">我要登陆</span>
<div class="masked">
    <div class="alert">
        <div class="popup">
            <div class="popup-hd clearfix">
                <span class="title">登陆</span>
                <span class="close"><i class="icon iconfont">&#xe661;</i></span>
            </div>
            <div class="popup-bd">
                <form action="http://<?= $_SERVER['SERVER_NAME'],$_SERVER['REQUEST_URI'] ?>login.php" id="loginForm">
                    <div class="login-from clearfix">
                        <div class="field">
                            <div class="field-hint">用户名</div>
                            <input type="text" name="username" id="username" value="" tabindex="1" onfocus="focusInput($(this))" autocomplete="off" onkeyup="checkUsername($(this))" >
                        </div>
                        <div class="field">
                            <div class="field-hint">密码</div>
                            <input type="password" name="password" id="password" value="" tabindex="2" onfocus="focusInput($(this))" autocomplete="off"  onkeyup="checkPassword($(this))">
                        </div>
                    </div>
                    <div class="submit clearfix">
                    <span class="active">
                        <i class="icon iconfont">&#xe65e;</i>
                        <span class="font">确认激活</span>
                    </span>
                        <input type="hidden" id="token" value="<?= $csrf_key ?>">
                        <span class="login-btn">登陆</span>
                    </div>
                </form>
            </div>
            <div class="popup-ft">
                <div class="protocol">
                    <h6>一、百宝盒平台和服务</h6>
                    <p>1. 协议，网络协议的简称，网络协议是通信计算机双方必须共同遵从的一组约定。如怎么样建立连接、怎么样互相识别等。只有遵守这个约定，计算机之间才能相互通信交流。它的三要素是：语法、语义、时序。1969年12月，美国国防部高级计划研究署的分组交换网ARPANET投入运行，从此计算机网络发展进入新纪元。ARPANET当时仅有4个结点，分别在美国国防部、原子能委员会、麻省理工学院和加利福利亚。这4台计算机之间进行数据通信仅有传送数据的通路是不够的，还必须遵守一些事先约定好的规则，由这些规则明确所交换数据的格式及有关同步问题。人与人之间交谈需要使用同一种语言，如果语言不同则需要翻译，否则两人之间无法沟通。计算机之间的通信过程和人与人之间的交谈过程非常相似，前者由计算机控制，后者由参加交谈的人控制。</p>
                    <p>2. 网络是一个信息交换的场所，所有接入网络的计算机都可以通过彼此之间的物理连设备进行信息交换，这种物理设备包括最常见的电缆、光缆、无线WAP和微波等，但是单纯拥有这些物理设备并不能实现信息的交换，这就好像人类的身体不能缺少大脑的支配一样，信息交换还要具备软件环境，这种“软件环境”是人类事先规定好的一些规则，被称作“协议”，有了协议，不同的电脑可以遵照相同的协议使用物理设备，并且不会造成相互之间的“不理解”。</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script src="./js/check.js"></script>
</body>
</html>