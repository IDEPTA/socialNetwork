<?php

namespace App\Orchid\Layouts\Charts;

use Orchid\Screen\Layouts\Chart;

class ChartPie extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';
    protected $colors = [
        '#F75C03',
        '#2274A5',
    ];

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
