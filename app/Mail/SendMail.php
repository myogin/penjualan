<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $penjualan = \App\Penjualan::findOrFail($this->data['id']);
        $products = \App\Product::All();
        $customers = \App\Customer::All();
        return $this->from('luthviningtyasputri@gmail.com')->subject('New Customer Equiry')
        ->view('penjualans.invoiceMail',['penjualan' => $penjualan, 'products' => $products, 'customers' => $customers])->with('data', $this->data);
    }
}
