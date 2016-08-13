<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxb6cf251d37626105", "050fbca3c90728e206b6ae6261aff32b");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>fly</title>
    <style type="text/css"> 
    *{
      margin: 0;
      padding: 0;
    }
    img{
      vertical-align: top;
    }
    html,body,canvas{
      width: 100%;
      height: 100%;
      margin: 0;padding: 0
    }
    /*html{font-size: 100px;}*/
    .wrap{
      width: 100%;
      height: 100%;
      position: relative;
    }
    canvas{
      position: absolute;
      top: 0;
      left: 0;
    }
    .p1{
      font-size: 30px;
      z-index: 1;
      position: absolute;
      top: 0;
      left: 0;
      line-height: 60px;
      padding-left: 20px;
    }
    .start{
      width: 250px;
      height: 60px;
      border: 2px solid black;
      position: absolute;
      top: 30%;
      left: 0;
      right: 0;
      margin: auto;
      z-index: 2;
      text-align: center;
      line-height: 50px;
      border-radius: 40px;
      background: gray;
      opacity: 0.7;
      display: none;
      line-height: 60px;
      font-size: 30px;
    }
    .rank{
      width: 250px;
      height: 60px;
      border: 2px solid black;
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      margin: auto;
      z-index: 2;
      text-align: center;
      line-height: 50px;
      border-radius: 40px;
      background: gray;
      opacity: 0.7;
      display: none;
      line-height: 60px;
      font-size: 30px;
    }
    .continue{
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      margin: auto;;
      width: 200px;
      height: 50px;
      font-size: 35px;
      line-height: 50px;
      text-align: center;
      z-index: 1;
      border: 2px solid black;
      border-radius: 25px;
      background: gray;
      opacity: 0.7;
      display: none;
    }
    .end{
      width: 80%;
      height: 80%;
      position: absolute;
      top: 10%;
      right: 0;
      left: 0;
      margin: auto;
      z-index: 1;
      border: 2px solid black;
      font-size: 16px;
      border-radius: 20px;
      background: gray;
      display: none;
    }
    .end .menu{
      position: relative;
      overflow: hidden;
      height: 90%;
    }
    .end .menu ul{
      position: relative;
      top: 0;
    }
    #restart{
      border: none;
      margin: auto;
      text-align: center;
      width: 90%;
      height: 10%;
      line-height: 0.5rem;
    }
    #restart span{
      text-align: center;
      border-radius: 20px;
      width: 40%;
      height: 60%;
      line-height: 0.30rem;
      border: 1px solid black;
      display: inline-block;
    }
    #restart span:nth-child(1){
      margin-right: 10%;
    }
    .end li:nth-child(1){
      font-size: 24px;
      text-align: center;
    }
    li{
      list-style: none;
      text-align: left;
      width: 90%;
      height: 50px;
      line-height: 50px;
      border-bottom: 1px solid black;
      box-sizing: border-box;
      margin: auto;
    }
    li img{
      height: 50px;
      position: absolute;
      left: 14%;
    }
    li span:nth-child(2){
      position: absolute;
      left: 35%;
    }
    li span:nth-child(3){
      float: right;
    }
    .wrap p img{
      padding-left: 20px
    }
    </style>
  </head>
  <body>
    
    <div class="wrap">

      <p class="p1">分数:<span id="s">0</span> <br> <img id="paused" src="img/game_pause.png" alt=""></p>
      <!-- 开始游戏 -->
      <div class="start">
        开始游戏
      </div>
      <div class="rank">查看排行榜</div>
      <!--  继续游戏 -->
      <div  class="continue" id="continue">继续游戏</div>
      <!-- 结束游戏 -->
      <div class="end">
        <div class="menu">
          <ul>
            
          </ul>
        </div>
        <div id="restart"><span>重新开始</span>
          <span>立即分享</span></div>
      </div>
      
      <canvas></canvas>
    </div> 
    <!-- 背景音乐 -->
    <audio src="sound/game_music.mp3" volume='0.1'></audio>
    <audio src="sound/bullet.mp3"></audio>
    <audio src="sound/enemy1_down.mp3"></audio>
    <audio src="sound/enemy2_down.mp3"></audio>
    <audio src="sound/enemy3_down.mp3"></audio>
    <audio src="sound/enemy2_out.mp3"></audio>
    <audio src="sound/game_over.mp3"></audio>
    <audio src="sound/enemy1_down.mp3"></audio>
    <audio src="sound/enemy2_down.mp3"></audio>
    <audio src="sound/enemy3_down.mp3"></audio>
    
  </body>
  <script type="text/javascript" src="js/object.js"></script>
  <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
  <script type="text/javascript">
    (function(html){
      change()
      function change(){
        var w = html.clientWidth;
        var size = 100*(w/375).toFixed(2);
        html.style.fontSize = size+"px"
      }
      window.addEventListener('resize',function () {
        change()
      })
    })(document.documentElement);

    // //获取元素
    var audio = document.querySelectorAll('audio');//所有音乐
    var canvas = document.getElementsByTagName('canvas')[0];
    var ctx = canvas.getContext('2d');
    canvas.width = document.documentElement.clientWidth;
    canvas.height = document.documentElement.clientHeight;
    var str = location.href;
    var arrId = str.split("=");
    var openid = arrId[1];
    //图片数组
    var arr =['img/background_2.png','img/hero_fly_1.png','img/hero_fly_2.png','img/hero_blowup_1.png','img/hero_blowup_2.png','img/hero_blowup_3.png','img/hero_blowup_4.png','img/bullet1.png','img/enemy1_fly_1.png','img/enemy1_blowup_1.png','img/enemy1_blowup_2.png','img/enemy1_blowup_3.png','img/enemy1_blowup_4.png','img/enemy2_fly_1.png','img/enemy2_blowup_1.png','img/enemy2_blowup_2.png','img/enemy2_blowup_3.png','img/enemy2_blowup_4.png','img/enemy2_blowup_5.png','img/enemy2_blowup_6.png','img/enemy2_blowup_7.png','img/enemy3_fly_1.png','img/enemy3_blowup_1.png','img/enemy3_blowup_2.png','img/enemy3_blowup_3.png','img/enemy3_blowup_4.png','img/hero_blowup_1.png','img/hero_blowup_2.png','img/hero_blowup_3.png','img/hero_blowup_4.png','img/enemy5_fly_1.png','img/bullet2.png','img/bomb.png','img/enemy4_fly_1.png'];
    //存取已加载图片数组
    var oArr = [];

    //分数
    var score = 0;
    //记录游戏开始
    var start_bol = false;
    //记录玩家飞机死亡
    var over = false
    //玩家姓名
    var oTxt = document.getElementById('txt');
    //开始游戏
    var oStart = document.getElementsByClassName('start')[0];
    //暂停游戏
    var oPaused = document.getElementById('paused');
    //继续游戏
    var oContinue = document.getElementById('continue');
    //游戏进行时分数
    var S = document.getElementById('s');
    //重新开始
    var oRestart = document.getElementById('restart');
    var restart = oRestart.getElementsByTagName('span')[0];
    //分享
    var share = oRestart.getElementsByTagName('span')[1];
    //结束界面
    var end = document.getElementsByClassName('end')[0];
    //记录计时器（浏览器计时器）
    var id = null;

    //显示分数
    s.innerHTML = score
    //开始按钮事件
    oStart.onclick = function(){
      this.style.display='none';
      $('.rank').hide();
      start()
      start_bol = true;
    }
    //暂停游戏按钮事件
    oPaused.onclick = function(){
      //判断游戏是否可以停止
      if (start_bol==false || over == true) {return}
      //显示继续游戏，并暂停游戏
      oContinue.style.display = 'block';
      cancelAnimationFrame(id);//停止计时器
      audio[0].pause();
    }
    //重新开始按钮事件
    restart.onclick = function(){
      //取消显示重新开始
      restart.parentNode.parentNode.style.display = 'none';
      //重置数据，并开始游戏
      over = false
      start_bol = true
      score = 0
      s.innerHTML = score
      start();
    }

    wx.config({
        debug: true,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
          // 所有要调用的 API 都要加到这个列表中
          'onMenuShareAppMessage'
        ]
    });

      wx.ready(function () {
        wx.onMenuShareAppMessage({
          title: '打飞机小游戏', // 分享标题
           desc: '测试测试', // 分享描述
          link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb6cf251d37626105&redirect_uri=http://brokeplane.applinzi.com/get.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', // 分享链接
          imgUrl: 'http://brokeplane.applinzi.com/plan/img/hero_blowup_3.png', // 分享图标
          type: 'link', // 分享类型,music、video或link，不填默认为link
          dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
          success: function () { 
              alert('分享成功')
          },
          cancel: function () { 
              // 用户取消分享后执行的回调函数
          }
        });
      });

    get(function (num,data) {
      for (var i = 0; i < num.length; i++) {
        arr.push(data[i].headimgurl);
      }
      return arr
    })
    //预加载
    loading(arr,function () {
      //设置延时，先出现loading
      setTimeout(function () {
        cancelAnimationFrame(id)
        oStart.style.display = 'block'
        $('.rank').show();
        start()
        cancelAnimationFrame(id);//停止
      },1000)
    })

    function start() {
      //背景
      var bg = new Bg(320,568)
      //玩家..
      var hero = new Hero(66,82);
      //子弹
      var Bu = new Bullet(6,14,48);
      //敌机
      var foe = new Diji(34,24, 's');
      //大飞机
      var enemy = new Diji(110,164,'l');

      //中飞机
      var ene = new Diji(46,60,'m');
      //炸弹
      var bom = new Bom(39,68,38,58,36);

      //每帧动画函数
      step()
      function step() {
        //合并敌机对象数组
        var oldArr = foe.arr.concat(enemy.arr,ene.arr);
        //游戏音乐
        audio[0].play()
        //画背景
        bg.draw();
        if (over) {//如果玩家飞机死亡
          audio[0].pause()
          end.style.display = 'block'
          $('ul').html('');
          get(function (num,data) {
            $('<li>本周飞机大战排行榜</li>').appendTo($('ul'))
            for (var i = 0; i < num; i++) {
              $('<li>'+(i+1)+'<img src="'+data[i].headimgurl+'" alt=""><span class="">'+data[i].nickname+'</span><span class="score">'+data[i].scole+'分</span></li>').appendTo($('ul'));
              $('ul').on('touchstart',function (e) {
                var disY = e.touches[0].clientY;
                var p = $(this).offset().top;
                var n = $(this).parent().offset().top;
                // console.log(p)
                $('ul').on('touchmove',function (e) {
                  var y = e.touches[0].clientY-disY;
                  var ys = y+p
                  if (ys>=n) {ys=n}
                  if (ys<=-$(this).height()+$(this).parent().height()+n) {ys=-$(this).height()+$(this).parent().height()+n}
                  $(this).offset({top:ys});
                })
              })
            }
          });
          return
        }
        hero.draw(audio[0],audio[6]);//画出玩家飞机
        Bu.draw(hero,oldArr,audio[1]);//画出子弹
        foe.draw(hero,audio[2],audio[7]);//画出敌机
        enemy.draw(hero,audio[3],audio[8]);//画出敌机
        ene.draw(hero,audio[4],audio[9]);//画出敌机
        bom.draw(hero,Bu)//补给功能
        s.innerHTML = score//显示分数
        
        id = requestAnimationFrame(step);//递归
      }
      
      //继续游戏
      oContinue.onclick = function(){
        oContinue.style.display = 'none'
        id = requestAnimationFrame(step);
      }
      //拖拽飞机 + 点击炸弹
      var dx = 0,dy = 0;
      canvas.addEventListener('touchstart',function (e) {
        var x = e.touches[0].clientX
        var y = e.touches[0].clientY
        dx = e.touches[0].clientX-hero.x;
        dy = e.touches[0].clientY-hero.y;
        // 点击炸弹
        ctx.beginPath()
        ctx.rect(5,canvas.height-bom.hs-10,bom.w,bom.h)
        ctx.closePath()
        if (ctx.isPointInPath(x,y)&&bom.index>0){
          bom.index--
          for (var i = 0; i < foe.arr.length; i++) {
            foe.arr[i].die=true
          }
          for (var i = 0; i < enemy.arr.length; i++) {
            enemy.arr[i].die=true
          }
          for (var i = 0; i < ene.arr.length; i++) {
            ene.arr[i].die=true
          }
        }
        e.preventDefault();
        
      })
      canvas.addEventListener('touchmove',function (e) {
        hero.x = e.touches[0].clientX-dx;
        hero.y = e.touches[0].clientY-dy;
        if (hero.x<0) {
          hero.x=0
        }else if (hero.x>canvas.width-hero.w) {
            hero.x=canvas.width-hero.w
        } 

        if (hero.y<0) {
          hero.y=0
        }else if (hero.y>canvas.height-hero.h) {
          hero.y=canvas.height-hero.h
        }
      })
    }
    //图片预加载
    function loading(arr,over) {
      var x = 0
      function loadmove() {
        var img = new Image()
        img.src='img/background_2.png'
        var img1 = new Image()
        img1.src='img/loading3.png'
        img.onload = function() {
          ctx.drawImage(img,0,0,320,568,0,0,canvas.width,canvas.height)
          img1.onload = function() {
            ctx.drawImage(img1,0,0,116,25,x,canvas.height/2-25/2,116,25)
          }
        }
        
        x+=5
        if (x+116>canvas.width) {x=0}
        id= requestAnimationFrame(loadmove);
      }
      loadmove()
      var index = 0;
      for (var i = 0; i < arr.length; i++) {
        var img = new Image();
        img.src = arr[i];
        oArr.push(img)
        img.onload = function () {
          index++;
          if (index==arr.length) {
            over&&over()
          }

        }
      }
    }
    //获取排行榜函数
    function get(cb) {
      $.ajax({
        type:"get",
        url:'php/score.php',
        data:{score:score,openid:openid},
        dataType:'json',
        success:function (data) {
          if (data.length>=20) {var num = 20}
          else if(data.length<20){var num = data.length}
          cb&&cb(num,data);  
          // for (var i = 0; i < num; i++) {
          //   $('<li>'+(i+1)+'<img src="'+data[i].headimgurl+'" alt=""><span class="">'+data[i].nickname+'</span><span class="score">'+data[i].scole+'分</span></li>').appendTo($('ul'));
          // }
        }
      })
    }

  </script>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'scanQRCode',
      'startRecord',
      'stopRecord',
      'playVoice',
      'onMenuShareAppMessage'
    ]
  });
  var btn = document.querySelector('input');
  var button = document.querySelectorAll('button');
  wx.ready(function () {

    wx.onMenuShareAppMessage({
      title: '打飞机小游戏', // 分享标题
       desc: '测试测试', // 分享描述
      link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb6cf251d37626105&redirect_uri=http://brokeplane.applinzi.com/get.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', // 分享链接
      imgUrl: 'http://brokeplane.applinzi.com/plan/img/hero_blowup_3.png', // 分享图标
      type: 'link', // 分享类型,music、video或link，不填默认为link
      dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
      success: function () { 
          alert('分享成功')
      },
      cancel: function () { 
          // 用户取消分享后执行的回调函数
      }
    });

  });
</script>
</html>










