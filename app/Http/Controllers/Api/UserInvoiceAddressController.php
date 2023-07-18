<?php

namespace App\Http\Controllers\Api;

use App\Enums\InvoiceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserInvoiceAddress\UserInvoiceAddressResource;
use App\Models\UserInvoiceAddress;
use Illuminate\Http\Request;

class UserInvoiceAddressController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(UserInvoiceAddress::class, 'address');
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
    }

    public function show(UserInvoiceAddress $address)
    {
        $result = $address->loadCount([
            'invoices',
            'invoices as paid_invoices_count' => fn($query) => $query->whereIn('status', [InvoiceStatus::Paid->value, InvoiceStatus::PartiallyPaid->value]),
            'transactionsIncoming',
            'transactionsOutgoing'
        ])
            ->loadSum('transactionsIncoming', 'amount_usd')
            ->loadSum('transactionsOutgoing', 'amount_usd');

        return UserInvoiceAddressResource::make($result);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
