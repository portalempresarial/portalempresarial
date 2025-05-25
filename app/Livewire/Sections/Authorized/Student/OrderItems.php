<?php

namespace App\Livewire\Sections\Authorized\Student;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderItems extends Component
{
    public $managing, $current_order, $order, $enableManage;

    public function downloadPdf($orderId)
    {
        try {
            $order = Order::find($orderId);

            $total = 0;

            foreach (OrderProduct::where('order_id', $orderId)->get() as $product) {
                if ($product->product) {
                    $total += $product['amount'] * $product->product->price;
                }
            }

            $seller = Company::find($order['seller_company_id']);
            $imagePath = null;
            $sellerIconBase64 = null;

            if ($seller && $seller->icon) {
                $imagePath = storage_path('app/public/companies/' . $seller->icon);
                $sellerIconBase64 = $this->getBase64FromImage($imagePath);
            }

            $pdf = PDF::loadView('pdf.order', [
                'order' => $order->toArray(),
                'products' => OrderProduct::where('order_id', $orderId)->get(),
                'seller' => $seller,
                'buyer' => Company::find($order['buyer_company_id']),
                'total' => $total,
                'icon' => $sellerIconBase64
            ])->setPaper('A4');

            return response()->streamDownload(function () use ($pdf) {
                echo  $pdf->stream();
            }, 'Portal Empresarial - ' . $order['serial'] . '.pdf');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function manage($identifier)
    {
        try {
            $this->managing = true;
            $this->current_order = Order::find($identifier);
        } catch (\Exception $e) {
            $this->managing = null;
        }
    }

    public function confirm()
    {
        try {
            $this->current_order->update(['status' => 'processed']);
            $this->managing = null;
        } catch (\Exception $e) {
            $this->managing = null;
        }
    }
    private function getBase64FromImage($imagePath)
    {
        if (!file_exists($imagePath)) {
            return null;
        }
        $image = file_get_contents($imagePath);
        return base64_encode($image);
    }

    public function mount($order, $enableManage = true)
    {
        $this->order = $order;
        $this->enableManage = $enableManage;
    }

    public function render()
    {
        return view('livewire.sections.authorized.student.order-items');
    }
}
