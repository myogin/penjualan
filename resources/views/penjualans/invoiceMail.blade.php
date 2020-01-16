<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Balinese Classic Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }

        .invoice-box table tr td:nth-child(3) {
            text-align: right;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                Balinese Classic
                            </td>

                            <td style="text-align: right;">
                                Invoice #: {{$penjualan->invoice_number}}<br>
                                Created: {{$tanggal_transaksi =date('M/d/Y', strtotime($penjualan->tanggal_transaksi))}}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                    <strong>Balinese Classic</strong><br>
                                    Address: Jalan Kebo Iwa XIII<br>
                                    Phone: (+62) 0895342574617<br>
                                    Email: yoginugraha19@gmail.com
                            </td>

                            <td style="text-align: right;">
                                    <strong>{{$penjualan->customer->nama}}</strong><br>
                                    Address: {{$penjualan->customer->address}}<br>
                                    Company: {{$penjualan->customer->perusahaan}}<br>
                                    Phone: {{$penjualan->customer->phone}}<br>
                                    Email: {{$penjualan->customer->email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Qty
                </td>

                <td>
                    Price
                </td>
                <td>
                    Price
                </td>
            </tr>
            @php
                function rupiah($angka){

                    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                    return $hasil_rupiah;

                }
            @endphp
            @foreach ($penjualan->products as $value)
            <tr class="item">
                <td>
                        {{$value->nama_produk}}
                </td>

                <td>
                        {{$value->pivot->qty}}
                </td>

                <td>
                        {{rupiah($value->pivot->harga_jual)}}
                </td>
                <td>
                        {{rupiah($value->pivot->qty*$value->pivot->harga_jual)}}
                </td>
            </tr>
            @endforeach

            <tr class="total">
                <td>Pembayaran pada rek BCA:</td>
                <td></td>
                <td>Subtotal:</td>
                <td>
                        {{rupiah($penjualan->total_harga)}}
                </td>
            </tr>
            <tr class="total">
                <td>6874387776</td>
                <td></td>
                <td>Tax (10%)</td>
                <td>
                        {{rupiah($penjualan->total_harga/100*10)}}
                </td>
            </tr>
            <tr class="total">
                <td>A/N Made Yogi Nugraha</td>
                <td></td>
                <td>Shipping</td>
                <td>
                        {{rupiah($penjualan->shipping)}}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td>Total:</td>
                <td>
                        @php
                        $total = $penjualan->total_harga+($penjualan->total_harga/100*10)+20000 ;
                        echo rupiah($total);
                    @endphp
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
