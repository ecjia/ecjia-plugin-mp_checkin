<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
/**
 * 微信签到
 */
defined('IN_ECJIA') or exit('No permission resources.');

use Ecjia\App\Platform\Plugin\PlatformAbstract;
use Ecjia\App\Wechat\WechatRecord;

class mp_checkin extends PlatformAbstract
{
    /**
     * 获取插件代号
     *
     * @see \Ecjia\System\Plugin\PluginInterface::getCode()
     */
    public function getCode()
    {
        return $this->loadConfig('ext_code');
    }

    /**
     * 加载配置文件
     *
     * @see \Ecjia\System\Plugin\PluginInterface::loadConfig()
     */
    public function loadConfig($key = null, $default = null)
    {
        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php', $key, $default);
    }

    /**
     * 加载语言包
     *
     * @see \Ecjia\System\Plugin\PluginInterface::loadLanguage()
     */
    public function loadLanguage($key = null, $default = null)
    {
        $locale = RC_Config::get('system.locale');

        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . '/languages/'.$locale.'/plugin.lang.php', $key, $default);
    }

    /**
     * 获取iconUrl
     * {@inheritDoc}
     * @see \Ecjia\App\Platform\Plugin\PlatformAbstract::getPluginIconUrl()
     */
    public function getPluginIconUrl()
    {
        if ($this->loadConfig('ext_icon')) {
            return RC_Plugin::plugin_dir_url(__FILE__) . $this->loadConfig('ext_icon');
        }
        return '';
    }

    /**
     * 事件回复
     * {@inheritDoc}
     * @see \Ecjia\App\Platform\Plugin\PlatformAbstract::eventReply()
     */
    public function eventReply() {
        $point_status = $this->config['point_status'];

        if (empty($point_status)) {
            return null;
        }

        $openid = $this->getMessage()->get('FromUserName');
        $wechatUUID = new \Ecjia\App\Wechat\WechatUUID();
        $uuid   = $wechatUUID->getUUID();

        if (! $this->hasBindUser()) {

            return $this->forwardCommand('mp_userbind');

        } else {


    		if (isset($point_status) && $point_status == 1) {
                $point_value = $this->getConfig('point_value');

                // 积分赠送
                $this->give_point($openid, $point_value);

                $articles = array(
                    'Title'         => '签到成功',
                    'Description'   => sprintf("获取%s积分~~", $point_value),
                    'Url'           => RC_Uri::url('platform/plugin/show', array('handle' => 'mp_jfcx/init', 'openid' => $openid, 'uuid' => $uuid)),
                    'PicUrl'        => RC_Plugin::plugin_dir_url(__FILE__) . '/images/wechat_thumb_pic_success.png',
                );
            } else {
                $articles = array(
                    'Title'         => '签到次数已完',
                    'Description'   => '明天再来签到吧~~',
                    'Url'           => RC_Uri::url('platform/plugin/show', array('handle' => 'mp_jfcx/init', 'openid' => $openid, 'uuid' => $uuid)),
                    'PicUrl'        => RC_Plugin::plugin_dir_url(__FILE__) . '/images/wechat_thumb_pic.png',
                );
            }
        }

        return WechatRecord::News_reply($this->getMessage(), $articles['Title'], $articles['Description'], $articles['Url'], $articles['PicUrl']);
    }

    /**
     * 积分赠送
     */
    private function give_point($openid, $point_value) {

        $point_status = $this->getConfig('point_status');
        $point_interval = $this->getConfig('point_interval');
        $point_num = $this->getConfig('point_num');
        $point_value = $this->getConfig('point_value');

        // 开启积分赠送
        if ($point_status == 1) {

            $count = \Ecjia\App\Wechat\Models\WechatPointModel::where('openid', $openid)->where('keywords', $this->getConfig('ext_code'))
                                        ->where('createtime', '>', RC_DB::raw('(UNIX_TIMESTAMP(NOW())- ' .$point_interval . ')'))
                                        ->count();

            if ($count < $point_num) {
                $this->do_point($openid, $point_value);
            }
        }
    }

    /**
     * 执行赠送积分
     */
    private function do_point($openid, $point_value) {

        $user_id = $this->getEcjiaUserId();

    	$log_id = RC_Api::api('finance', 'pay_points_change', [
    	    'user_id' => $user_id,
    	    'point' => $point_value,
    	    'change_desc' => '积分赠送-微信签到',
        ]);

    	if (! is_ecjia_error($log_id)) {
            $data = [
                'log_id' => $log_id,
                'openid' => $openid,
                'keywords' => $this->getConfig('ext_code'),
                'createtime' => RC_Time::gmtime(),
            ];
            \Ecjia\App\Wechat\Models\WechatPointModel::insert($data);
        }
    }
}

// end