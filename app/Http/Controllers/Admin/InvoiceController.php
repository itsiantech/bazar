<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;



class InvoiceController extends Controller
{
    private  $moduleName="Order";
    private $singularVariableName = 'order';
    private $pluralVariableName = 'orders';
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new Order();
    }
    public function invoice() {

        $client = new Party([
            'name'          => 'BangoShop',
            'phone'         => '01717 000 000',
            'custom_fields' => [
                'Address'        => '5/A House: 16, Road: 10, Sector: 13, Uttara',
                'Hot line' => '06539',
            ],
        ]);

        $customer = new Party([
            'name'          => 'Ashley Medina',
            'address'       => 'The Green Street 12',
            'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);

        $items = [
            (new InvoiceItem())->title('Service 1')->pricePerUnit(47.79),

        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('receipt')
            ->series('BIG')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('')
            ->currencyCode('BDT')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)


            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }


}
