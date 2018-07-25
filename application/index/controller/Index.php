<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    protected $beforeActionList = [
     'beforehello' => ['only' => 'hello']
    ];
    public function beforehello()
    {
      echo 'this is berforehello'.'</br>';
    }
    public function hello()
    {
      echo 'hello';
    }
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }
    public function testJson()
    {
      $person_array = [
          'name' => 'tom',
          'age' => 4,
          'job' => 'php',
      ];
      dump($person_str = serialize(serialize($person_array)));
      echo file_put_contents('./test.txt', $person_str);
      dump(unserialize(file_get_contents('./test.txt')));
      // dump($person_array);
      $person_json = json_encode($person_array);
      dump($person_json);
      // dump($obj = json_decode($person_json));
      // echo $obj->name;
      // dump(json_decode($person_json,true));
    }
    public function testXML()
    {
       header('Content-Type:text/xml;charset=utf8');
       $str = '<?xml version="1.0" encoding="utf-8"?>';
       $str .= '<person>';
       $str .= '<name>tom</name>';
       $str .= '<age>4</age>';
       $str .= '<job>php</job>';
       $str .= '</person>';
       echo file_put_contents('person.xml',$str);
    }
    public function readXML()
    {
      $xmlStr = file_get_contents('person.xml');
      $xmlObj = simplexml_load_string($xmlStr);
      dump($xmlObj);
      echo $xmlObj->name;
    }
    // 测试使用request
    public function testRequest()
    {
      $url = 'https://www.taobao.com';
      // function request($url,$https=false,$method='get',$data=null)
      dump(request($url,true));
    }
    // 调用天气
    public function weather()
    {
      // 1、url
      $url = 'https://restapi.amap.com/v3/weather/weatherInfo?key=6b1ff1437e732d134b4f89a84ace6519&city=北京&extensions=all&output=XML';
      // 2、发送请求方式
      // 3、发送请求
      $content = request($url,true);
      // 4、处理返回值
      // 接收的数据是xml
      $obj = simplexml_load_string($content);
      // dump($content);
      $cast = $obj->forecasts->forecast->casts->cast;
      foreach ($cast as $key => $value) {
        // dump($value);
        echo '日期:'.$value->date;
        echo '周:'.$value->week;
        if($value->dayweather == '雷阵雨'){
          echo '白天天气:<img style="width:50px;" src="http://pic43.photophoto.cn/20170609/0470102328984879_b.jpg"/>';
        }
        echo '夜间天气:'.$value->nightweather;
        echo '白天温度:'.$value->daytemp;
        echo '夜间温度:'.$value->nighttemp;
        echo '白天风向:'.$value->daywind;
        echo '夜间风向:'.$value->nightwind;
        echo '白天风力:'.$value->daypower;
        echo '夜间风力:'.$value->nightpower;
        echo '<hr />';
      }
    }
    // 调用天气
    public function weather1()
    {
      // 1、url
      $url = 'https://restapi.amap.com/v3/weather/weatherInfo?key=6b1ff1437e732d134b4f89a84ace6519&city=北京&extensions=all&output=JSON';
      // 2、发送请求方式
      // 3、发送请求
      $content = request($url,true);
      // 4、处理返回值
      // 接收的数据是JSON
      // dump($content);
      $content = json_decode($content,true);
      // dump($content['forecasts'][0]['casts']);
      foreach ($content['forecasts'][0]['casts'] as $key => $value) {
        echo '日期:'.$value['date'];
        echo '周:'.$value['week'];
        if($value['dayweather'] == '雷阵雨'){
          echo '白天天气:<img style="width:50px;" src="http://pic43.photophoto.cn/20170609/0470102328984879_b.jpg"/>';
        }
        echo '夜间天气:'.$value['nightweather'];
        echo '白天温度:'.$value['daytemp'];
        echo '夜间温度:'.$value['nighttemp'];
        echo '白天风向:'.$value['daywind'];
        echo '夜间风向:'.$value['nightwind'];
        echo '白天风力:'.$value['daypower'];
        echo '夜间风力:'.$value['nightpower'];
        echo '<hr />';
      }
    }
    // 提供手机号码归属地查询
    public function getAreaByPhone()
    {
      //1、接收参数
      //get方式不允许请求
      if (request()->isGet()){
        exit();
      }
      // 只接受post的传值方式
      $phone = input('phone');
      // 前面条件如果成立，就执行:前面的,如果不成立就执行 冒号后面的
      // 接收到的format数据的格式  不为空，就使用接收到的  如果没有接收到  默认为json
      $format = !empty(input('format'))? input('format'):'json';
      //2、校验参数是否合法(符合规则)
      //11的num的手机号  手机号
      preg_match("/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7,9]))\d{8}$/", $phone,$matchs);
      // dump($matchs);die();
      if(empty($matchs)){
        return json_encode(['status' => 10000,'msg' => '传入有效的手机号码']);
      }
      // 1335428  取出7位查询
      //substr(str,start,length)
      $areaNum = substr($phone,0,7);
      // echo $areaNum;die();
      //3、携带合法参数进行数据查询
      $data = db('mobile')->where('mobile',$areaNum)->find();
      // echo db('mobile')->getLastSQL();die();
      // dump($data);
      //4、根据约定格式返回数据  xml json
      if($format == 'json'){
        return json_encode($data);
      }else{
        $xmlStr = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlStr .= '<data>';
        $xmlStr .= '<province>'.$data['province'].'</province>';
        $xmlStr .= '<city>'.$data['city'].'</city>';
        $xmlStr .= '<sp>'.$data['sp'].'</sp>';
        $xmlStr .= '</data>';
        // header('Content-Type:text/xml');
        return $xmlStr;
      }
    }
    public function searchAreaByPhone()
    {
      return view('searchAreaByPhone');
    }
    // php调用接口
    public function testAreaByPhone()
    {
        // 1、url
        $url = 'http://localhost/php67tp5/public/index.php/index/Index/getAreaByPhone/format/json/phone/15035299702';
        // 2、参数发送请求方式
        // 3、发送请求
        // function myRequest($url=null,$https=false,$method='get',$data=null)
        $content = myRequest($url);
        // 4、处理返回值
        $content = json_decode($content);
        // dump($content);die();
        echo '省份:'.$content->province.'<br />';
        echo '城市:'.$content->city.'<br />';
        echo '运营商:'.$content->sp.'<br />';
    }
    // 相册图片添加
    public function pics()
    {
      // 通过请求方式的不同  采用不同的处理方法
      if(request()->isGet()){
        // 加载页面
        return view('pics');
      }else{
        // 接收上传参数
        $data = request()->param();
        $data['url'] = $this->upload();
        // dump($data);die();
        $rs = db('pic')->insert($data);
        // 插入成功返回的是主键
        // var_dump($rs);
        if($rs == 1){
          // $this->success();
          echo json_encode(['code' => 1000,'msg' => '添加成功', 'url' => $data['url']]);
          // echo "<script>window.location.href='".url('pics')."'</script>";
        }
      }
    }
    public function upload(){
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file('headimg');
      // 移动到框架应用根目录/public/uploads/ 目录下
      if($file){
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
          // 返回保存后的路径
          return 'uploads'.DS.$info->getSaveName();
        }else{
          // 上传失败获取错误信息
          echo $file->getError();
         }
      }
    }
    public function picsList()
    {
      // $data = db('pic')->select();
      $data = db('pic')->paginate(5);
      $this->assign('list',$data);
      return view('picList');
    }
    // 折线图
    public function line()
    {
      $this->assign('data',str_replace('"', '', $this->lineWeather()));
      return view('line_basic');
    }
    // 温度数据
    // 调用天气
    public function lineWeather()
    {
      // 1、url
      $url = 'https://restapi.amap.com/v3/weather/weatherInfo?key=6b1ff1437e732d134b4f89a84ace6519&city=北京&extensions=all&output=JSON';
      // 2、发送请求方式
      // 3、发送请求
      $content = myRequest($url,true);
      // 4、处理返回值
      // 接收的数据是JSON
      // dump($content);die();
      $content = json_decode($content,true);
      // dump($content['forecasts'][0]['casts']);die();
      $new_weather = [];
      foreach ($content['forecasts'][0]['casts'] as $key => $value) {
        $new_weather[$value['week']] = $value['daytemp'];
      }
      // var_dump($new_weather);die();
      // return json_encode($new_weather);
      $jsonStr = '[';
      foreach ($new_weather as $key => $value) {
        $jsonStr .= '['.$key.','.$value.'],';
      }
      $jsonStr = rtrim($jsonStr,',');
      return $jsonStr.']';
    }
    // 饼状图
    public function pie()
    {
      return view('pie_basic');
    }
    // button
    public function button()
    {
      return view('button');
    }

}
