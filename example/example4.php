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
$chart->setBorderColor(\RWypior\Objgd\Unit\Color::fromRGB(0, 0, 0, 0.5));
$chart->setBorderThickness(1.5);
$chart->setLabelDistance(0.7);
$chart->setTextColor(\RWypior\Objgd\Unit\Color::fromName('white'));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('An entry', 394, \RWypior\Objgd\Unit\Color::fromHex('9b972e')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Some name', 97, \RWypior\Objgd\Unit\Color::fromHex('417b26')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry', 197, \RWypior\Objgd\Unit\Color::fromHex('9d2b22')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry b', 100, \RWypior\Objgd\Unit\Color::fromHex('9b972e')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry c', 100, \RWypior\Objgd\Unit\Color::fromHex('417b26')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry d', 100, \RWypior\Objgd\Unit\Color::fromHex('9d2b22')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry e', 100, \RWypior\Objgd\Unit\Color::fromHex('9b972e')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry f', 100, \RWypior\Objgd\Unit\Color::fromHex('417b26')));
$chart->addData(new \RWypior\Objgd\Model\PieChartDataset('Another entry g', 100, \RWypior\Objgd\Unit\Color::fromHex('9d2b22')));
imageantialias($img->getGDHandle(), true);

$img->drawElement($chart);

header('Content-Type: image/png');
$img->output(NULL,\RWypior\Objgd\Image::TYPE_PNG);