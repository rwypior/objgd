<?php

include('../vendor/autoload.php');

$img = \RWypior\Objgd\Image::createEmpty(new \RWypior\Objgd\Unit\Coord(500, 500));

$square = new \RWypior\Objgd\Drawable\Rectangle(new \RWypior\Objgd\Unit\Coord('70%', '55%'), new \RWypior\Objgd\Unit\Coord(50, 50));
$square->setFillColor(\RWypior\Objgd\Unit\Color::fromName('red'));
$square->setBorderColor(\RWypior\Objgd\Unit\Color::fromName('white'));
$square->setThickness(3);

$font = new \RWypior\Objgd\Font('fonts/Roboto-Regular.ttf', 'fonts/Roboto-Bold.ttf', 'fonts/Roboto-Italic.ttf');

$text = new \RWypior\Objgd\Drawable\Text();
$text->setFont($font);
$text->setText('Lorem ipsum dolor [i]sit[/i] [b]amet[/b]');

$text2 = new \RWypior\Objgd\Drawable\Text();
$text2->setFont($font);
$text2->setText("Centered text with\nmultiple lines\nbla bla bla");
$text2->setAlign(\RWypior\Objgd\Unit\Align::center());
$text2->setCoord(new \RWypior\Objgd\Unit\Coord('50%', 50));

$text3 = new \RWypior\Objgd\Drawable\Text();
$text3->setFont($font);
$text3->setText('Right-aligned text');
$text3->setAlign(\RWypior\Objgd\Unit\Align::right());
$text3->setCoord(new \RWypior\Objgd\Unit\Coord(0, 100));

$text4 = new \RWypior\Objgd\Drawable\Text();
$text4->setFont($font);
$text4->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum velit id tortor hendrerit sollicitudin.');
$text4->setAlign(\RWypior\Objgd\Unit\Align::justified());
$text4->setCoord(new \RWypior\Objgd\Unit\Coord('50%', 150));
$text4->setMaxWidth('50%');

$line = new \RWypior\Objgd\Drawable\Line(new \RWypior\Objgd\Unit\Coord(0, '50%'), new \RWypior\Objgd\Unit\Coord('100%', '50%'));

$circle = new \RWypior\Objgd\Drawable\Ellipse(new \RWypior\Objgd\Unit\Coord('70%', '75%'), new \RWypior\Objgd\Unit\Coord(50, 50));
$circle->setBorderColor(\RWypior\Objgd\Unit\Color::fromName('blue'));
$circle->setThickness(3);



$img2 = \RWypior\Objgd\Image::createEmpty(new \RWypior\Objgd\Unit\Coord(500, 500));
$img2->fill(\RWypior\Objgd\Unit\Color::fromRGB(255, 255, 255, 0.3));

$img2square = new \RWypior\Objgd\Drawable\Rectangle(new \RWypior\Objgd\Unit\Coord('50%', '50%'), new \RWypior\Objgd\Unit\Coord(50, 50));
$img2square->setFillColor(\RWypior\Objgd\Unit\Color::fromName('green'));

$img2line = new \RWypior\Objgd\Drawable\Line(new \RWypior\Objgd\Unit\Coord(0, '50%'), new \RWypior\Objgd\Unit\Coord('100%', '50%'));
$linestyle = new \RWypior\Objgd\Model\LineStyle(IMG_COLOR_STYLED, false);
$linestyle->addSegment(\RWypior\Objgd\Unit\Color::fromName('red'), 200);
$linestyle->addSegment(\RWypior\Objgd\Unit\Color::fromName('white'), 200);
$img2line->setStyle($linestyle);
$img2line->setThickness(10);

$img2->drawElement($img2square);
$img2->drawElement($img2line);

$imgDraw = new \RWypior\Objgd\Drawable\Image($img2);
$imgDraw->setSize(new \RWypior\Objgd\Unit\Coord(200, 100));
$imgDraw->setCoord(new \RWypior\Objgd\Unit\Coord(0, '75%'));

$img->drawElement($square)
    ->drawElement($text)
    ->drawElement($text2)
    ->drawElement($text3)
    ->drawElement($text4)
    ->drawElement($circle)
    ->drawElement($line)
    ->drawElement($imgDraw);

header('Content-Type: image/jpeg');
$img->output();