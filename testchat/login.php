        <script type="text/javascript" src="js/lib/jquery/jquery.js"></script>
        <script type="text/javascript" src="js/lib/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="js/lib/bootstrap/bootstrap.js"></script>
        <script type="text/javascript" src="js/lib/bootstrap/bootstrap-table.js"></script>
        <script type="text/javascript" src="js/lib/bootstrap/bootstrap-collapse.js"></script>
        <!--TLS web sdk(只用于托管模式，独立模式不用引入)-->
        <script type="text/javascript" src="https://tls.qcloud.com/libs/api.min.js"></script>
        <!--用于获取文件MD5 js api(Sent图片时用到)-->
        <script type="text/javascript" src="js/lib/md5/spark-md5.js"></script>
        
        <!--web im sdk-->
        <script type="text/javascript" src="sdk/webim.js"></script>
        <script type="text/javascript" src="sdk/json2.js"></script>
        
        <!--web im sdk 登录 示例代码-->
        <script type="text/javascript" src="js/login/login.js"></script>
        <!--web im sdk 登出 示例代码-->
        <script type="text/javascript" src="js/logout/logout.js"></script>
        <!--web im 解析一条消息 示例代码-->
        <script type="text/javascript" src="js/common/show_one_msg.js"></script>
        <!--web im demo 基本逻辑-->
        <script type="text/javascript" src="js/base.js"></script>
        <!--web im sdk 资料管理 api 示例代码-->
        <script type="text/javascript" src="js/profile/profile_manager.js"></script>
        <!--web im sdk 好友管理 api 示例代码-->
        <script type="text/javascript" src="js/friend/friend_manager.js"></script>
        <!--web im sdk 好友申请管理 api 示例代码-->
        <script type="text/javascript" src="js/friend/friend_pendency_manager.js"></script>
        <!--web im sdk 好友黑名单管理 api 示例代码-->
        <script type="text/javascript" src="js/friend/friend_black_list_manager.js"></script>
        <!--web im sdk 群组管理 api 示例代码-->
        <script type="text/javascript" src="js/group/group_manager.js"></script>
        <!--web im sdk 群成员管理 api 示例代码-->
        <script type="text/javascript" src="js/group/group_member_manager.js"></script>
        <!--web im sdk 加群申请管理 api 示例代码-->
        <script type="text/javascript" src="js/group/group_pendency_manager.js"></script>
        <!--web im 切换聊天好友或群组 示例代码-->
        <script type="text/javascript" src="js/switch_chat_obj.js"></script>
        <!--web im sdk 获取c2c获取群组历史消息 示例代码-->
        <script type="text/javascript" src="js/msg/get_history_msg.js"></script>
        <!--web im sdk Sent普通消息(文本和表情) api 示例代码-->
        <script type="text/javascript" src="js/msg/send_common_msg.js"></script>
        <!--web im sdk 上传和Sent图片消息 api 示例代码-->
        <script type="text/javascript" src="js/msg/upload_and_send_pic_msg.js"></script>
        <!--web im sdk 切换播放语音消息 示例代码-->
        <script type="text/javascript" src="js/msg/switch_play_sound_msg.js"></script>
        <!--web im sdk Sent自定义消息 api 示例代码-->
        <script type="text/javascript" src="js/msg/send_custom_msg.js"></script>
        <!--web im 监听新消息(c2c或群) 示例代码-->
        <script type="text/javascript" src="js/msg/receive_new_msg.js"></script>
        <!--web im 监听群 System Message消息 示例代码-->
        <script type="text/javascript" src="js/msg/receive_group_system_msg.js"></script>
        <!--web im 监听好友 System Message消息 示例代码-->
        <script type="text/javascript" src="js/msg/receive_friend_system_msg.js"></script>
        <!--web im 监听资料 System Message消息 示例代码-->
        <script type="text/javascript" src="js/msg/receive_profile_system_msg.js"></script>
        
        <script type="text/javascript">
            
            //帐号模式，0-表示独立模式，1-表示托管模式
            var accountMode=0;
            
            //官方 demo appid,需要开发者自己修改（托管模式）
            var sdkAppID = 1400013878;
            var accountType = 7078;

            //当前用户身份
            var loginInfo = {
                    'sdkAppID': "1400013878", //用户所属应用id,必填
                    'accountType': "7078", //用户所属应用帐号类型，必填
                    'identifier': null, //当前用户ID,必须是否字符串类型，必填
                    'identifierNick': null, //当前用户昵称，选填
                    'userSig': null, //当前用户身份凭证，必须是字符串类型，必填
                    'headurl': 'img/2016.gif'//当前用户默认头像，选填
            };
            
            var selType = webim.SESSION_TYPE.C2C;//当前聊天类型
            var selToID = null;//当前选中聊天id（当聊天类型为私聊时，该值为好友帐号，否则为群号）
            var selSess = null;//当前聊天会话对象
            
            
            //默认好友或群头像
            var friendHeadUrl = 'img/2017.jpg';
            
            var maxNameLen=5;//My Friends或群组列表中名称显示最大长度，仅demo用得到
            var reqMsgCount = 15;//每次请求的历史消息(c2c获取群)条数，进demo用得到
            var pageSize = 15;//表格的每页条数，bootstrap table 分页时用到
            var totalCount = 200;//每次接口请求的条数，bootstrap table 分页时用到
            
            var emotionFlag = false;//是否打开过表情Select框
            
            var curPlayAudio=null;//当前正在播放的audio对象
            
            var getPrePageC2CHistroyMsgInfoMap={};//保留下一次拉取好友历史消息的信息
            var getPrePageGroupHistroyMsgInfoMap={};//保留下一次拉取群历史消息的信息
            
            var defaultSelGroupId=null;//登录默认选中的群id，选填，仅demo用得到
            
            //监听（多终端同步）群系统消息方法，方法都定义在receive_group_system_msg.js文件中
            //注意每个数字代表的含义，比如，
            //1表示监听申请加群消息，2表示监听申请加群被同意消息，3表示监听申请加群被拒绝消息
            var onGroupSystemNotifys={
                "1": onApplyJoinGroupRequestNotify,//申请加群请求（只有管理员会收到）
                "2": onApplyJoinGroupAcceptNotify,//申请加群被同意（只有申请人能够收到）
                "3": onApplyJoinGroupRefuseNotify,//申请加群被拒绝（只有申请人能够收到）
                "4": onKickedGroupNotify,//被管理员踢出群(只有被踢者接收到)
                "5": onDestoryGroupNotify,//群被解散(全员接收)
                "6": onCreateGroupNotify,//创建群(创建者接收)
                "7": onInvitedJoinGroupNotify,//邀请加群(被邀请者接收)
                "8": onQuitGroupNotify,//主动退群(主动退出者接收)
                "9": onSetedGroupAdminNotify,//设置管理员(被设置者接收)
                "10": onCanceledGroupAdminNotify,//取消管理员(被取消者接收)
                "11": onRevokeGroupNotify,//群已被回收(全员接收)
                "255": onCustomGroupNotify//用户自定义通知(默认全员接收)
            };
            
            //监听好友 System Message函数对象，方法都定义在receive_friend_system_msg.js文件中
            var onFriendSystemNotifys={
                "1": onFriendAddNotify,//好友表增加
                "2": onFriendDeleteNotify,//好友表删除
                "3": onPendencyAddNotify,//未决增加
                "4": onPendencyDeleteNotify,//未决删除
                "5": onBlackListAddNotify,//黑名单增加
                "6": onBlackListDeleteNotify//黑名单删除
            };
            
            //监听资料 System Message函数对象，方法都定义在receive_profile_system_msg.js文件中
            var onProfileSystemNotifys={
                "1": onProfileModifyNotify//资料修改  
            };
            
            //监听连接状态回调变化事件
            var onConnNotify=function(resp){
                var info;
                switch(resp.ErrorCode){
                    case webim.CONNECTION_STATUS.ON:
                        webim.Log.warn('建立连接成功: '+resp.ErrorInfo);
                        break;
                    case webim.CONNECTION_STATUS.OFF:
                        info='连接已断开，无法收到新消息，请检查下你的网络是否正常: '+resp.ErrorInfo;
                        alert(info);
                        webim.Log.warn(info);
                        break;
                    case webim.CONNECTION_STATUS.RECONNECT:
                        info='连接状态恢复正常: '+resp.ErrorInfo;
                        alert(info);
                        webim.Log.warn(info);
                        break;
                    default:
                        webim.Log.error('未知连接状态: ='+resp.ErrorInfo);
                        break;
                }
            };
            
            //IE9(含)以下浏览器用到的jsonp回调函数
            function jsonpCallback(rspData) {
                webim.setJsonpLastRspData(rspData);
            }
            
            //监听事件
            var listeners = {
                "onConnNotify": onConnNotify,//监听连接状态回调变化事件,必填
                "jsonpCallback": jsonpCallback,//IE9(含)以下浏览器用到的jsonp回调函数，
                "onMsgNotify": onMsgNotify,//监听新消息(私聊，普通群(非直播聊天室)消息，全员推送消息)事件，必填
                "onBigGroupMsgNotify": onBigGroupMsgNotify,//监听新消息(直播聊天室)事件，直播场景下必填
                "onGroupSystemNotifys": onGroupSystemNotifys,//监听（多终端同步）群系统消息事件，如果不需要监听，可不填
                "onGroupInfoChangeNotify": onGroupInfoChangeNotify,//监听群资料变化事件，选填
                "onFriendSystemNotifys": onFriendSystemNotifys,//监听好友 System Message事件，选填
                "onProfileSystemNotifys": onProfileSystemNotifys//监听资料系统（自己或好友）通知事件，选填
            };
            
            var isAccessFormalEnv=true;//是否访问正式环境
                        
            if(webim.Tool.getQueryString("isAccessFormalEnv")=="false"){
                isAccessFormalEnv=false;//访问测试环境
            }
                        
            var isLogOn=true;//是否开启sdk在控制台打印日志
                        
            //初始化时，其他对象，选填
            var options={
                'isAccessFormalEnv': isAccessFormalEnv,//是否访问正式环境，默认访问正式，选填
                'isLogOn': isLogOn//是否开启控制台打印日志,默认开启，选填
            }
            
            if(accountMode==1){//托管模式
                //判断是否已经拿到临时身份凭证
                if (webim.Tool.getQueryString('tmpsig')) {
                    if (loginInfo.identifier == null) {
                        webim.Log.info('start fetchUserSig');
                        //获取正式身份凭证，成功后会回调tlsGetUserSig(res)函数
                        TLSHelper.fetchUserSig();
                    }
                } else {//未登录
                    if (loginInfo.identifier == null) {
                        //弹出Select应用类型对话框
                        //$('#select_app_dialog').modal('show');
                        webim.Tool.setCookie('accountType', loginInfo.accountType, 3600 * 24);
                        //调用tls登录服务
                        tlsLogin();
                        $("body").css("background-color", 'white');
                    }
                }
            }else{//独立模式
                $('#login_dialog').modal('show');
            }
            
        </script>
 

<?php
if(!isset($_POST['submit'])){
    exit('invalid visit!');
}
$username = $_POST['username'];
$password = $_POST['password'];
echo $username;
echo $password;
exec("python /home/ubuntu/imap/src/basic/account.py $username $password",$output,$return_val);
if ($output[0]==TRUE){
    echo "TRUE";
    echo "<script type='text/javascript'>independentModeLogin($username,$password);</script>";
}
if ($output[0]==FALSE){
    echo "FALSE";
}
?>