<?php


namespace rnadvanceemailingwc\core\Integration;


class FilterManager
{
    static function ApplyFilters($hook,$args)
    {
        return \apply_filters($hook,$args);
    }
}