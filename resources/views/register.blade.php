<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>用户注册</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{env('APP_URL')}}/js/rem.js"></script>
    <link rel="stylesheet" href="{{env('APP_URL')}}/css/ResetCss.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/css/index.css?v3">
    <script src="{{env('APP_URL')}}/js/zepto.js"></script>
    <script src="{{env('APP_URL')}}/js/svgxuse.js"></script>
</head>
<body style="background: #f3f3f3;">
<div class="content">
    <img src="https://zz-med-national.oss-cn-hangzhou.aliyuncs.com/CminiProgram/images/TYCL2.jpg" class="banner">
    <div class="userForm">
        <div class="tips"><span class="asterisk">*</span>号标注为必填项</div>
        {{--<div class="name">--}}
            {{--<span class="asterisk1">*</span>--}}
            {{--<input type="text" id="name" placeholder="请输入姓名">--}}
        {{--</div>--}}
        {{--<div class="sex">--}}
            {{--<span class="asterisk1">*</span>--}}
            {{--<div class="sexType">--}}
                {{--<div data-id="0">男</div>--}}
                {{--<div class="sexWomen" id="women" data-id="1">女</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="calendar">--}}
            {{--<span class="asterisk1">*</span>--}}
            {{--<input type="date" id="bday" placeholder="请选择出生年月日">--}}
            {{--<div class="svg" id="svg"></div>--}}
        {{--</div>--}}
        <div class="phone">
            <span class="asterisk1">*</span>
            <input type="number" oninput="if(value.length>11) value=value.slice(0,11)" placeholder="请输入手机号" id="phone">
        </div>
        <div class="verificationCode">
            <span class="asterisk1">*</span>
            <input type="text" placeholder="请输入验证码" id="txtVerificationCode" class="verificationCodeNums">
            <button class="getNums">获取</button>
        </div>
        <button class="Submission">报名</button>
    </div>
    <div id="shade"></div>
    <div id="modal" class="falsePhoneNum">
        <p class="showText">请输入正确的手机号</p>
        <div id="closeModal">确定</div>
    </div>
</div>
</body>

<script>


    Date.prototype.format = function (format) {

        /*
         * 使用例子:format="yyyy-MM-dd hh:mm:ss";
         */
        var o = {
            "M+": this.getMonth() + 1, // month
            "d+": this.getDate(), // day
            "h+": this.getHours(), // hour
            "m+": this.getMinutes(), // minute
            "s+": this.getSeconds(), // second
            "q+": Math.floor((this.getMonth() + 3) / 3), // quarter
            "S": this.getMilliseconds()
            // millisecond
        };

        if (/(y+)/.test(format)) {
            format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4
                - RegExp.$1.length));
        }

        for (var k in o) {
            if (new RegExp("(" + k + ")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length == 1
                    ? o[k]
                    : ("00" + o[k]).substr(("" + o[k]).length));
            }
        }
        return format;
    };

    $(function () {

        // 解决ios段样式不兼容的问题
        var u = navigator.userAgent, app = navigator.appVersion;
        var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);     //ios终端
        if (isIOS) {
            $('.sexType div').css({'height': '0.9rem', 'lineHeight': '0.9rem', 'width': '2.3rem'})
            $('.sexType').css({'height': '0.9rem', 'width': '5.5rem'})
            $('.getNums').css({'height': '0.95rem', 'lineHeight': '0.95rem'})
            $('#women').css({'marginLeft': '0.3rem'})
            $('.svg').css({'marginLeft': '5.75rem'})
        }

        let clickDisable = false;
        // 解决移动端的点击事件
        if ('addEventListener' in document) {
            document.addEventListener('DOMContentLoaded', function () {
                FastClick.attach(document.body);
            }, false);
        }
        //
        // var o = document.getElementById('bday');
        // o.onfocus = function () {
        //     this.removeAttribute('placeholder');
        // };
        // o.onblur = function () {
        //     if (this.value == '') this.setAttribute('placeholder', '我是日期');
        // };

        // 点击不同的性别改变其背景颜色
        $(".sexType div").click(function () {
            $(this).addClass("selectNow").siblings().removeClass("selectNow");
        });

        // 点击获取验证码
        $('.getNums').click(function () {
            $(this).attr({"disabled": "disabled"})
            let phoneNum = $.trim($('#phone').val());

            if (phoneNum === '') {
                $('.showText').html('请输入手机号！')
                $('#shade').css('display', 'block')
                $('#modal').css('display', 'block')
                $(this).removeAttr("disabled")
                return false
            }

            const reg = /^1\d{10}$/
            if (!reg.test(phoneNum)) {
                $('.showText').html('请输入正确的手机号码！')
                $('#shade').css('display', 'block')
                $('#modal').css('display', 'block')
                $(this).removeAttr("disabled")
                return false
            }

            let _self= $(this)
            $.ajax({
                type: 'POST',
                url: '/api/sms/send',
                data: JSON.stringify({
                    "cell": phoneNum,
                    "type": 1,
                }),
                contentType: 'application/json',
                success: function (data) {
                    let res = data;
                    if (res.code !== 1) {
                        $('.showText').html('验证码发送失败！')
                        $('#shade').css('display', 'block')
                        $('#modal').css('display', 'block')
                        $('.getNums').removeAttr("disabled")
                        return false
                    } else {
                        var count = 60;
                        let timer = setInterval(() => {
                            count--;
                            if (count > 0) {
                                $('.getNums').attr({"disabled": "disabled"}).css({background: '#CACACA'})[0].innerHTML = count + 's后' + '重新获取'
                            } else {
                                $('.getNums').removeAttr("disabled").css({background: '#F67710'})[0].innerHTML = '获取';
                                clearInterval(timer)
                            }
                        }, 1000);
                    }
                },
                error: function (error, type) {
                    let resERROR = $.parseJSON(error.response)
                    alert(resERROR.error)
                    _self.removeAttr("disabled")
                }
            })

        })


        // // 手机号码验证码的正则
        $('.Submission').click(function () {
            let that = this
            // let name = $.trim($('#name').val());
            // if (name === '') {
            //     $('.showText').html('请输入姓名！')
            //     $('#shade').css('display', 'block')
            //     $('#modal').css('display', 'block')
            //     return false
            // }
            //
            // let sex = $.trim($('.selectNow').attr('data-id'));
            // if (sex === '') {
            //     $('.showText').html('请选择性别！')
            //     $('#shade').css('display', 'block')
            //     $('#modal').css('display', 'block')
            //     return false
            // }
            //
            // let bday = $.trim($('#bday').val());
            // if (bday === '') {
            //     $('.showText').html('请输入出生年月！')
            //     $('#shade').css('display', 'block')
            //     $('#modal').css('display', 'block')
            //     return false
            // }
            //
            // var newDay = new Date()
            // var year = newDay.getFullYear()
            // let inputDate = new Date(bday).getTime()
            // let today = new Date().getTime()
            // if (inputDate > today) {
            //     $('.showText').html('出生年份的范围为1900-' + year + ',请确认！')
            //     $('#shade').css('display', 'block')
            //     $('#modal').css('display', 'block')
            //     return false
            // }

            let phoneNum = $.trim($('#phone').val());
            var phoneReg = /^1\d{10}$/;
            if (!phoneReg.test(phoneNum)) {
                $('.showText').html('请输入正确的手机号！')
                $('#shade').css('display', 'block')
                $('#modal').css('display', 'block')

                return false
            }

            let verificationCode = $.trim($('#txtVerificationCode').val());
            if (verificationCode === '') {
                $('.showText').html('请输入验证码！')
                $('#shade').css('display', 'block')
                $('#modal').css('display', 'block')
                return false
            }


            $(this).attr({"disabled": "disabled"})

            let userInfo = {
                "uuid": "{{$docId}}",
                "openid": "{{$openId}}",
                "cell": phoneNum,
                "verify_code": verificationCode,
            };

            let _self = $(this)
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/user/register',
                data: JSON.stringify(userInfo),
                contentType: 'application/json',
                success: function (data) {
                    let res = data;
                    if (res.code === 1) {
                        window.location.href = "/user/register_succeed";
                        _self.removeAttr("disabled")
                    }
                },
                error: function (error, type) {

                    let resERROR = $.parseJSON(error.response)
                    alert(resERROR.error)
                    _self.removeAttr("disabled")
                }
            })

        });


        $('#closeModal').click(function () {
            $('#shade').css('display', 'none')
            $('#modal').css('display', 'none')
        })

    })
</script>
</html>