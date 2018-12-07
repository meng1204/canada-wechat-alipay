<?php

namespace AlphaPay;


abstract class Base
{
    /**
     * 微信组件
     *
     * @var alphapay
     */
    protected $alphapay;

    /**
     * @param AlphaPay $alphapay
     */
    public function __construct($alphapay)
    {
        $this->alphapay = $alphapay;
    }
}