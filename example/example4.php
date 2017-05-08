<?php

include('../vendor/autoload.php');

$img = \RWypior\Objgd\Image::createEmpty(new \RWypior\Objgd\Unit\Coord(600, 500));
imageantialias($img->getGDHandle(), true);
$img->fill(\RWypior\Objgd\Unit\Color::fromName('black'));

$font = new \RWypior\Objgd\Font('fonts/Roboto-Regular.ttf', 'fonts/Roboto-Bold.ttf', 'fonts/Roboto-Italic.ttf');

$chart = new \RWypior\Objgd\Drawable\PieChart();
$chart->setSize(new \RWypior\Objgd\Unit\Coord(300, 300));
$chart->setCoord(new \RWypior\Objgd\Unit\Coord('50%', '50%'));
$chart->setFont($font);
$chart->setDrawNames(true);
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('An entry', 100, \RWypior\Objgd\Unit\Color::fromHex('9b972e')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Some name', 150, \RWypior\Objgd\Unit\Color::fromHex('417b26')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry', 300, \RWypior\Objgd\Unit\Color::fromHex('9d2b22')));
$chart->setBorderColor(\RWypior\Objgd\Unit\Color::fromName('black'));

$img->drawElement($chart);

header('Content-Type: image/png');
$img->output(NULL,\RWypior\Objgd\Image::TYPE_PNG);