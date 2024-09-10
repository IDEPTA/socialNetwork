<?php

namespace App\Orchid\Layouts\Charts;

use Orchid\Screen\Layouts\Chart;

class ChartLine extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'line';
    protected $colors = [
        '#2274A5',
        '#F75C03',
    ];

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
