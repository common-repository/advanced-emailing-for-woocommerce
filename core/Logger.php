<?php

namespace rnadvanceemailingwc\core;

class Logger
{
    /**
     * @return \WC_Logger
     */
    private static function GetLogger()
    {
        if(!function_exists('wc_get_logger'))
            return null;
        return \wc_get_logger();

    }
    public static function Info($message)
    {
        $logger=self::GetLogger();
        if($logger==null)
            return;
        $logger->info($message,[
            'source'=>'advanced-emailing'
        ]);

    }
}