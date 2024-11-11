<?php
//Esta es la clase php para dar manejo a los productos del carrito
class Item
{
    public $id;
    public $name;
    public $price;
    public $amount;
    public $subtotal;
    public $iva;
    public $total_iva;
    public $total;
    public $option_id;
    public $addition_id;


    public function __construct($id, $amount, $name, $price, $iva, $option_id, $addition_id = null)
    {
        $this->id           = $id;
        $this->name         = $name;
        $this->price        = $price;
        $this->amount       = $amount;
        $this->iva          = $iva;
        $this->total        = ($amount * $price);
        $this->subtotal     = $this->total / (1 + $iva / 100);
        $this->total_iva    = $this->total - $this->subtotal;

        $this->option_id    = $option_id;
        $this->addition_id  = $addition_id;
    }

    public function updateAmount($amount)
    {
        $this->amount       = $amount;
        $this->total        = ($this->amount * $this->price);
        $this->subtotal     = $this->total / (1 + $this->iva / 100);
        $this->total_iva    = $this->total - $this->subtotal;
    }
}
