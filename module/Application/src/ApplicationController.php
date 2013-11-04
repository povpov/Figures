<?php
namespace Application;

use FiguresLib\AwareColorInterface;
use FiguresLib\AwareLabelInterface;
use FiguresLib\Circle;
use FiguresLib\Color;
use FiguresLib\DrawingBoard\Gd;
use FiguresLib\Rectangle;

class ApplicationController extends AbstractController
{
    public function indexAction()
    {


        $params = $this->params();


        if ($this->isPost()) {
            if (isset($params['width'])) {
                $this->addCookie('width', $params['width']);
            }
            if (isset($params['height'])) {
                $this->addCookie('height', $params['height']);
            }

            $figures = $this->getCookie('figures');
            $figures = $figures ? json_decode($figures, true) : array();
            if ($params['figure']) {
                $figures[] = array(
                    'figure' => $params['figure'],
                    'x' => $params['x'],
                    'y' => $params['y'],
                    'radius' => $params['radius'],
                    'width' => $params['rWidth'],
                    'height' => $params['rHeight'],
                    'label' => $params['label'],
                    'color' => $params['color'],
                );
            }
            $this->addCookie('figures', json_encode($figures));
            header('Location: /');
        }

        $width = $this->getCookie('width', 400);
        $height = $this->getCookie('height', 200);
        $board = new Gd();
        $board
            ->setWidth($width)
            ->setHeight($height);


        $figures = $this->getCookie('figures');
        $figures = $figures ? json_decode($figures, true) : array();
        foreach ($figures as $figure) {
            $figure = $this->createFigure($figure);
            $board->addFigure($figure);
        }

        return new View(array(
            'board' => $board
        ));
    }

    private function createFigure($options)
    {
        $type = isset($options['figure']) ? strtolower($options['figure']) : 'circle';

        $class = 'FiguresLib\Circle';
        switch($type) {
            case 'colored_circle':
                $class = 'Figures\Circle';
                break;
            case 'rectangle':
                $class = 'FiguresLib\Rectangle';
                break;
            case 'colored_rectangle':
                $class = 'Figures\Rectangle';
                break;
        }

        $figure = new $class;
        if (isset($options['x'])) {
            $figure->setX($options['x']);
        }
        if (isset($options['y'])) {
            $figure->setY($options['y']);
        }
        if (isset($options['radius']) && $figure instanceof Circle) {
            $figure->setRadius($options['radius']);
        }
        if (isset($options['width']) && isset($options['height']) && $figure instanceof Rectangle) {
            $figure->setHeight($options['height']);
            $figure->setWidth($options['width']);
        }
        if ($figure instanceof AwareColorInterface) {
            if (isset($options['color'])) {
                $color = new Color();
                $color->setHEX($options['color']);
                $figure->setColor($color);
            }
        }
        if ($figure instanceof AwareLabelInterface) {
            $label = isset($options['label']) ? $options['label'] : '';
            $figure->setLabel($label);
        }

        return $figure;
    }
}