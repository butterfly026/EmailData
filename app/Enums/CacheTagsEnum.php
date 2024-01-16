<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum CacheTagsEnum: string
{
    use EnumTrait;

    /**
     * @color yellow
     */
    case GetCoinsMarkets = 'GetCoinsMarkets';
    /**
     * @color red
     */
    case GetCoinsPrice = 'GetCoinsPrice';
    /**
     * @color blue
     */
    case CoinPrice = 'CoinPrice';
    /**
     * @color green
     */
    case Vip = 'Vip';

    /**
     * @color grey
     */
    case PKLotteries = 'PKLotteries';

    /**
     * @color grey
     */
    case PKAlertStatus = 'PKAlertStatus';

    /**
     * @color pink
     */
    case OnlineStatus = 'OnlineStatus';

    /**
     * @color yellow
     */
    case Configs = 'Configs';

    /**
     * @color black
     */
    case FaFaBanks = 'FaFaBanks';
    case TelegramBotBroadcastPrice = 'TelegramBotBroadcastPrice';
}
