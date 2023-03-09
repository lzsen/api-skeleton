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

#[Constants]
class DataStatusConstant extends AbstractConstants
{
    /**
     * @Message("失败")
     */
    public const FAIL = 0;

    /**
     * @Message("成功")
     */
    public const SUCCESS = 1;
}
