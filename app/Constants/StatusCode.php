<?php

declare(strict_types=1);

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
class StatusCode extends AbstractConstants
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

    /* 其它相关 501…… */

    /* 其它相关 701…… */

    /* 其它相关 801…… */

    /* 其它相关 901…… */
}
