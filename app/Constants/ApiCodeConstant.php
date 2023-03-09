<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 状态码管理
 * 系统异常 - 1000以下
 * 自定义业务代码规范如下：
 * 授权相关 - 201……
 * 用户相关 - 301……
 * 验证相关 - 401……
 * 业务相关 - 601…….
 */
#[Constants]
class ApiCodeConstant extends AbstractConstants
{
    /* 系统异常 1000 */

    /**
     * @Message("ok")
     */
    public const SUCCESS = 0;

    /**
     * @Message("Internal Server Error!")
     */
    public const ERR_SERVER = 500;

    /* 授权相关 201…… */

    /* 用户相关 301…… */

    /* 验证相关 401…… */

    /**
     * @Message("请求参数不正确")
     */
    public const REQUEST_PARAMS_ERROR = 40100;

    /**
     * @Message("当前密码不一致")
     */
    public const PASSWD_MODIFY_CURRENT_PASSWD_ERROR = 40101;

    /**
     * @Message("新密码不正确")
     */
    public const PASSWD_MODIFY_NEW_PASSWD_ERROR = 40102;

    /**
     * @Message("两次新密码不一致")
     */
    public const PASSWD_MODIFY_CONFIRM_PASSWD_ERROR = 40103;

    /* 其它相关 501…… */

    /* 其它相关 601…… */
    /* 其它相关 701…… */

    /* 其它相关 801…… */

    /* 其它相关 901…… */

    /**
     * @Message("登录失败，账号或密码不正确")
     */
    public const ADMIN_AUTH_LOGIN_ERROR = 90100;

    /**
     * @Message("身份认证失败")
     */
    public const ADMIN_AUTH_JWT_ERROR = 90101;

    /**
     * @Message("登录异常，请稍后再试！")
     */
    public const ADMIN_AUTH_JWT_EXCEPTION = 90102;

    /**
     * @Message("无效的图形验证码")
     */
    public const ADMIN_AUTH_CAPTCHA_ERROR = 90103;
}
