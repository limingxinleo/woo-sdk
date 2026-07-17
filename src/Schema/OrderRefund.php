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

namespace Woo\Schema;

class OrderRefund
{
    /**
     * @param int $id Refund ID. READ-ONLY
     * @param string $reason Refund reason. READ-ONLY
     * @param string $total Refund total. READ-ONLY
     */
    public function __construct(
        public int $id = 0,
        public string $reason = '',
        public string $total = '',
    ) {
    }
}
