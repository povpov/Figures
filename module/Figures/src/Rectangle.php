<?php
namespace Figures;

use FiguresLib\AwareColorInterface;
use FiguresLib\AwareLabelInterface;
use FiguresLib\Color;
use FiguresLib\Rectangle as FiguresLibRectangle;
class Rectangle extends FiguresLibRectangle implements AwareColorInterface, AwareLabelInterface
{
    /** @var  string */
    protected $label;

    /** @var  Color */
    protected $color;

    /**
     * @param Color $color
     * @return mixed
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @param string $label
     * @return mixed
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}