<?php

namespace App\Support;

final class Money
{
    /**
     * Format an integer IDR amount into Rupiah display text.
     */
    public static function rupiah(int|float $amount): string
    {
        return 'Rp '.number_format((float) $amount, 0, ',', '.');
    }
}
