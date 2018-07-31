<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>积分查看</title>
    <link rel="stylesheet" type="text/css" href="{$css1_url}">
    <link rel="stylesheet" type="text/css" href="{$css2_url}">
    <link rel="stylesheet" type="text/css" href="{$css3_url}">


</head>
<body>

<div class="details-wrapper">
    <div class="details-info">
        <div class="info-cnt">
            <div class="info-cnt-inner">
                <div class="info-number">
                    <span class="info-txt">当前</span><span class="info-num">{$pay_points}</span><span class="info-txt">积分</span>
                </div>
                <div class="info-btn">
                    <i class="btn-icon"></i>
                    <span class="btn-text">已签到</span>
                </div>
                <div class="info-tips">已连续签到1天，继续加油哦</div>	            </div>
        </div>
<!--        <a href="javascript:void(0)" class="info-help">帮助说明</a>-->
    </div>
    <div class="details-notice">
    </div>
    <div class="details-list">
        <div class="list-head" id="listHead"><div class="list-head-inner">积分收支明细</div></div>
        <div class="place-holder"></div>
        <div class="list-box" id="listBox">
            <div class="list-item">
                <div class="cell list-item-left">
                    <div class="list-item-text">无线签到翻牌积分奖励</div>
                    <div class="list-item-time">2018-07-25 15:36:58</div>
                </div>
                <div class="list-item-right add">
                    +1
                </div>
            </div>
            <div class="list-item">
                <div class="cell list-item-left">
                    <div class="list-item-text">购物送积分(商品号:6514034)</div>
                    <div class="list-item-time">2018-07-22 09:54:36</div>
                </div>
                <div class="list-item-right add">
                    +15
                </div>
            </div>

            <div class="list-item">
                <div class="cell list-item-left">
                    <div class="list-item-text">订单77548388942使用积分992个</div>
                    <div class="list-item-time">2018-07-14 17:36:31</div>
                </div>
                <div class="list-item-right">
                    -992
                </div>
            </div>

        </div>
    </div>
    <div style="height:5px;"></div>
    <div class="loading-more hide">
        <div class="loading-ani">
                <span class="loading-more-l">
                    <i class="load-circel"></i>
                    <i class="load-logo"></i>
                </span>
            <span class="load-text">加载中...</span>
        </div>
    </div>
    <div class="ending-section hide">
        <div class="ending-title">加载更多</div>
    </div>
    <div style="height:5px;"></div>
</div>

<script type="text/javascript" src="{$jq_url}"></script>


</body>
</html>
<!-- {/nocache} -->