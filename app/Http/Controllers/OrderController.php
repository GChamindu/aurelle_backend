<?php

namespace App\Http\Controllers;

use App\Enums\OrderItemStatus;
use App\helpers\R2Helper;
use App\Jobs\SendNewOrderAdminEmail;
use App\Jobs\SendOrderDeliveredEmail;
use App\Models\Coloer;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderAttachment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // public function placeOrder(Request $request)
    // {
    //     $validated = $request->validate([
    //         'billing.name'          => 'required|string|max:255',
    //         'billing.email'         => 'required|email',
    //         'billing.phone'         => 'required|string|max:20',
    //         'billing.whatsapp'      => 'nullable|string|max:20',
    //         'billing.city'          => 'required|string|max:100',
    //         'billing.address'       => 'required|string|max:500',
    //         'billing.note'          => 'nullable|string',
    //         'cart'                  => 'required|array|min:1',
    //         'cart.*.product_id'     => 'required|exists:products,id',
    //         'cart.*.title'          => 'required|string',
    //         'cart.*.price'          => 'required|numeric|min:0',
    //         'cart.*.quantity'       => 'required|integer|min:1',
    //         'cart.*.color'          => 'nullable|string',
    //         'cart.*.size'           => 'nullable|string',
    //         'subtotal'              => 'required|numeric|min:0',
    //         'shipping_cost'         => 'required|numeric|min:0',
    //         'total_amount'          => 'required|numeric|min:0',
    //         'payment_method'        => 'required|in:cod,bank_transfer',
    //     ]);

    //     return DB::transaction(function () use ($validated) {
    //         $orderNumber = 'ORD-' . strtoupper(Str::random(8));

    //         $order = Order::create([
    //             'user_id'         => null,
    //             'order_number'    => $orderNumber,
    //             'subtotal'        => $validated['subtotal'],
    //             'shipping_cost'   => $validated['shipping_cost'],
    //             'total_amount'    => $validated['total_amount'],
    //             'payment_method'  => $validated['payment_method'],
    //             'payment_status'  => 'pending',
    //             'order_status'    => 'pending',
    //             'note'            => $validated['billing']['note'] ?? null,
    //         ]);

    //         OrderAddress::create([
    //             'order_id'  => $order->id,
    //             'name'      => $validated['billing']['name'],
    //             'email'     => $validated['billing']['email'],
    //             'phone'     => $validated['billing']['phone'],
    //             'whatsapp'  => $validated['billing']['whatsapp'],
    //             'city'      => $validated['billing']['city'],
    //             'address'   => $validated['billing']['address'],
    //         ]);

    //         foreach ($validated['cart'] as $item) {
    //             OrderItem::create([
    //                 'order_id'    => $order->id,
    //                 'product_id'  => $item['product_id'],
    //                 'title'       => $item['title'],
    //                 'price'       => $item['price'],
    //                 'quantity'    => $item['quantity'],
    //                 'color_id'    => $item['color'] ?
    //                     \App\Models\Coloer::where('name', $item['color'])->first()?->id : null,
    //                 'size_id'     => $item['size'] ?
    //                     \App\Models\Size::where('name', $item['size'])->first()?->id : null,
    //                 'status'      => OrderItemStatus::PENDING,
    //             ]);
    //         }

    //         return response()->json([
    //             'success'       => true,
    //             'order_number'  => $orderNumber,
    //             'message'       => 'Order placed successfully!',
    //         ]);
    //     });
    // }


    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'billing.name'          => 'required|string|max:255',
            'billing.email'         => 'required|email',
            'billing.phone'         => 'required|string|max:20',
            'billing.whatsapp'      => 'nullable|string|max:20',
            'billing.city'          => 'required|string|max:100',
            'billing.address'       => 'required|string|max:500',
            'billing.note'          => 'nullable|string',
            'cart'                  => 'required|array|min:1',
            'cart.*.product_id'     => 'required|exists:products,id',
            'cart.*.title'          => 'required|string',
            'cart.*.price'          => 'required|numeric|min:0',
            'cart.*.quantity'       => 'required|integer|min:1',
            'cart.*.color'          => 'nullable|string',
            'cart.*.size'           => 'nullable|string',
            'subtotal'              => 'required|numeric|min:0',
            'shipping_cost'         => 'required|numeric|min:0',
            'total_amount'          => 'required|numeric|min:0',
            'payment_method'        => 'required|in:cod,payhere,bank_transfer',

            'bank_slip'             => 'required_if:payment_method,bank_transfer',
        ]);

        $bankSlip = $request->file('bank_slip');

        return DB::transaction(function () use ($validated, $bankSlip) {
            $orderNumber = $this->generateOrderNumber();


            $order = Order::create([
                'user_id'         => null,
                'order_number'    => $orderNumber,
                'subtotal'        => $validated['subtotal'],
                'shipping_cost'   => $validated['shipping_cost'],
                'total_amount'    => $validated['total_amount'],
                'payment_method'  => $validated['payment_method'], // ← uncommented & saved
                'payment_status'  => 'pending',
                'order_status'    => 'pending',
                'note'            => $validated['billing']['note'] ?? null,
            ]);

            $this->handleBankSlipUpload($bankSlip, $order);

            OrderAddress::create([
                'order_id'  => $order->id,
                'name'      => $validated['billing']['name'],
                'email'     => $validated['billing']['email'],
                'phone'     => $validated['billing']['phone'],
                'whatsapp'  => $validated['billing']['whatsapp'],
                'city'      => $validated['billing']['city'],
                'address'   => $validated['billing']['address'],
            ]);

            foreach ($validated['cart'] as $item) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item['product_id'],
                    'title'       => $item['title'],
                    'price'       => $item['price'],
                    'quantity'    => $item['quantity'],
                    'color_id'    => $item['color'] ?
                        \App\Models\Coloer::where('name', $item['color'])->first()?->id : null,
                    'size_id'     => $item['size'] ?
                        \App\Models\Size::where('name', $item['size'])->first()?->id : null,
                    'status'      => OrderItemStatus::PENDING,
                ]);
            }


            if ($validated['payment_method'] === 'cod') {
                return response()->json([
                    'success'       => true,
                    'order_number'  => $orderNumber,
                    'message'       => 'Order placed successfully! (Cash on Delivery)',
                ]);
            }

            $orderItemsForEmail = [];
            foreach ($validated['cart'] as $item) {
                $orderItemsForEmail[] = [
                    'product_id' => $item['product_id'],
                    'title'      => $item['title'],
                    'quantity'   => $item['quantity'],
                    'color'      => $item['color'] ?? null,
                    'size'       => $item['size'] ?? null,
                    'price'      => $item['price'],
                ];
            }

            // Customer info
            $customerForEmail = [
                'name'  => $validated['billing']['name'],
                'email' => $validated['billing']['email'],
                'phone' => $validated['billing']['phone'],
            ];

            // Dispatch job
            SendNewOrderAdminEmail::dispatch($orderItemsForEmail, $customerForEmail);

            return response()->json([
                'success'       => true,
                'order_number'  => $orderNumber,
                // 'payment_url'   => $paymentUrl,
                'message'       => 'Redirecting to PayHere secure checkout...',
            ]);
        });
    }

    private function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');

        $lastOrder = Order::whereDate('created_at', now())
            ->latest('id')
            ->first();

        if (!$lastOrder) {
            $sequence = 1;
        } else {
            $lastNumber = intval(substr($lastOrder->order_number, -6));
            $sequence = $lastNumber + 1;
        }

        return 'ORD-' . $date . '-' . str_pad($sequence, 6, '0', STR_PAD_LEFT);
    }


    private function handleBankSlipUpload($file, Order $order): void
    {
        // 1. Check if the file actually exists (since it's nullable/conditional)
        if (!$file || !$file->isValid()) {
            return;
        }

        // 2. Gather file details
        $original = $file->getClientOriginalName();
        $mime     = $file->getMimeType();
        $size     = $file->getSize();
        $hash     = hash_file('sha256', $file->getRealPath());

        // 3. Store the file using your R2Helper
        $folder = 'slips/' . now()->format('Y/m');
        $storedPath = R2Helper::storeFile($file, $folder);

        if (!$storedPath) {
            \Log::warning("Failed to upload bank slip for order #{$order->order_number}");
            return;
        }

        // 4. Create the attachment record in the database
        OrderAttachment::create([
            'order_id'   => $order->id,
            'file_name'  => $original,
            'file_path'  => $storedPath,
            'file_hash'  => $hash,
            'mime_type'  => $mime,
            'file_size'  => $size,
        ]);
    }


    // Webhook / IPN (notify_url) - PayHere calls this server-to-server
    public function notify(Request $request)
    {
        Log::info('PayHere IPN received', [
            'ip' => $request->ip(),
            'data' => $request->all(),
        ]);

        $merchantId = '1233390';
        $secret     = 'MjE5MjQ3NTQzMzQwNjAwMzg2MjIyMDg0ODQ3NTA4MTY1MzMxNjYxNw==';

        $receivedHash     = $request->md5sig ?? '';
        $merchantIdReq    = $request->merchant_id;
        $orderId          = $request->order_id;
        $payhereAmount    = $request->payhere_amount;
        $payhereCurrency  = $request->payhere_currency;
        $statusCode       = $request->status_code;      // '2' = captured/success
        $statusMessage    = $request->status_message ?? 'No message';

        // Security: Verify merchant_id matches
        if ($merchantIdReq != $merchantId) {
            Log::warning('PayHere IPN invalid merchant_id', ['received' => $merchantIdReq]);
            return response('Invalid merchant', 400);
        }

        // Re-calculate hash (PayHere sends md5sig)
        $localHashString = $merchantId . $orderId . $payhereAmount . $payhereCurrency . strtoupper(md5($secret));
        $expectedHash    = strtoupper(md5($localHashString));

        if ($receivedHash !== $expectedHash) {
            Log::warning('PayHere IPN hash mismatch', [
                'received' => $receivedHash,
                'expected' => $expectedHash,
            ]);
            return response('Hash mismatch', 400);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning('PayHere IPN order not found', ['order_id' => $orderId]);
            return response('Order not found', 404);
        }

        if ($statusCode == '2') {
            // Success - update DB
            $order->update([
                'payment_status' => 'paid',
                'order_status'   => 'processing', // change to your next status
            ]);
            Log::info('PayHere payment SUCCESS', ['order' => $orderId]);
            // Optional: send confirmation email, reduce stock, etc.
        } else {
            // Failed / pending / cancelled
            Log::info('PayHere payment NOT success', [
                'order'   => $orderId,
                'status'  => $statusCode,
                'message' => $statusMessage,
            ]);
            // Optional: mark as failed
            $order->update(['payment_status' => 'failed']);
        }

        return response('OK', 200); // Must return 200 OK to PayHere
    }

    public function return(Request $request)
    {
        $orderId = $request->order_id ?? '';
        $order   = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return redirect('/')->with('error', 'Order not found.');
        }

        // Note: return_url is not secure - always trust IPN for status
        if ($order->payment_status === 'paid') {
            return redirect('/thank-you')->with('success', 'Payment successful! Order #' . $orderId);
        }

        return redirect('/checkout')->with('error', 'Payment not completed. Check your order status.');
    }

    public function cancel(Request $request)
    {
        $orderId = $request->order_id ?? '';
        return redirect('/checkout')->with('info', 'Payment cancelled. Order #' . $orderId . ' is pending.');
    }

    // public function buildOrderItemsData(Request $request)
    // {
    //     $orders = Order::with(['address', 'items.product.images', 'items.color', 'items.size'])
    //         ->latest()
    //         ->get();

    //     $data = [];

    //     foreach ($orders as $order) {
    //         $groupedItems = $order->items->groupBy('product_id');

    //         foreach ($groupedItems as $productId => $items) {
    //             $product = $items->first()->product;

    //             $productImage = $product?->images->first()
    //                 ? R2Helper::getFileUrl($product->images->first()->image_path)
    //                 : asset('admin_assets/img/placeholder.jpg');

    //             $itemsPreview = "
    //             <span class='table-imgname' data-bs-toggle='tooltip' data-bs-html='true'
    //                   title=\"<img src='{$productImage}' style='width:120px;border-radius:8px'><br>
    //                          <strong>{$product?->name}</strong>\">
    //                 <div style='display:flex; flex-direction:column; gap:4px;'>
    //                     <div><strong>{$product?->name}</strong></div>
    //                     <div class='product-sku'>Product ID: {$product?->product_id}</div>
    //                 </div>
    //             </span>";

    //             $variantHtml = $items->map(function ($item) {
    //                 $color = $item->color?->name ?? 'Default';
    //                 $size  = $item->size?->name ?? '-';
    //                 $img = $item->product?->images->first()
    //                     ? R2Helper::getFileUrl($item->product->images->first()->image_path)
    //                     : asset('admin_assets/img/placeholder.jpg');

    //                 return "<span data-bs-toggle='tooltip' data-bs-html='true'
    //                     title=\"<img src='{$img}' style='width:90px;border-radius:6px'><br>
    //                            <strong>Color:</strong> {$color}<br>
    //                            <strong>Size:</strong> {$size}<br>
    //                            <strong>Qty:</strong> {$item->quantity}\">
    //                     <strong>{$color}</strong> {$size} × {$item->quantity}
    //                 </span>";
    //             })->implode('<br>');

    //             $totalQty = $items->sum('quantity');
    //             $totalAmount = $items->sum(fn($i) => $i->quantity * $i->price);

    //             $statusBadge = match ($order->order_status) {
    //                 'pending'    => '<span class="badge-pending">Pending</span>',
    //                 'inprogress' => '<span class="badge-inactive">Inprogress</span>',
    //                 'delivered'  => '<span class="badge-active">Delivered</span>',
    //                 default      => '<span class="badge-delete">Cancelled</span>',
    //             };

    //             $productStatus = match (true) {
    //                 $items->every(fn($i) => $i->status === OrderItemStatus::DELIVERED)  => OrderItemStatus::DELIVERED,
    //                 $items->every(fn($i) => $i->status === OrderItemStatus::CANCELLED)  => OrderItemStatus::CANCELLED,
    //                 $items->contains(fn($i) => $i->status === OrderItemStatus::INPROGRESS) => OrderItemStatus::INPROGRESS,
    //                 default => OrderItemStatus::PENDING,
    //             };

    //             $action = "
    //             <div class='table-select'>
    //                 <select class='select2 order-status-select'
    //                     data-order='{$order->id}'
    //                     data-product='{$productId}'>
    //                     <option value='pending' " . ($productStatus === OrderItemStatus::PENDING ? 'selected' : '') . ">Pending</option>
    //                     <option value='inprogress' " . ($productStatus === OrderItemStatus::INPROGRESS ? 'selected' : '') . ">Inprogress</option>
    //                     <option value='delivered' " . ($productStatus === OrderItemStatus::DELIVERED ? 'selected' : '') . ">Delivered</option>
    //                     <option value='cancelled' " . ($productStatus === OrderItemStatus::CANCELLED ? 'selected' : '') . ">Cancelled</option>
    //                 </select>
    //             </div>";

    //             $data[] = [
    //                 'id'             => $order->id,
    //                 'items_preview'  => $itemsPreview,
    //                 'created_at'     => $order->created_at->format('d M Y H:i'),
    //                 'customer_name'  => $order->address?->name ?? 'N/A',
    //                 'address'        => $order->address
    //                     ? $order->address->address . ', ' . $order->address->city
    //                     : 'N/A',
    //                 'phone'          => $order->address?->phone ?? '',
    //                 'variants'       => $variantHtml,
    //                 'count'          => $totalQty,
    //                 'amount'         => 'LKR ' . number_format($totalAmount, 2),
    //                 'status'         => $statusBadge,
    //                 'action'         => $action,
    //                 'created_at_raw' => $order->created_at->timestamp,
    //             ];
    //         }
    //     }

    //     // Filter by requested status for tabs
    //     if ($request->status && $request->status !== 'all') {
    //         $data = array_filter($data, fn($row) => strtolower(strip_tags($row['status'])) === $request->status);
    //     }

    //     return response()->json(['data' => array_values($data)]);
    // }


    public function orderItems(Order $order)
    {
        // Pass ONLY this order's items to the view
        $data = $this->buildOrderItemsData($order);

        // Render Blade with order and its items
        return view('admin.orders.order_items', compact('order', 'data'));
    }


    public function buildOrderItemsData(Order $order)
    {
        $order->load(['address', 'items.product.images', 'items.color', 'items.size', 'attachments']);

        $data = [];

        $groupedItems = $order->items->groupBy('product_id');

        foreach ($groupedItems as $productId => $items) {

            $product = $items->first()->product;

            $productImage = $product?->images->first()
                ? R2Helper::getFileUrl($product->images->first()->image_path)
                : asset('admin_assets/img/placeholder.jpg');

            /* =========================
         | PRODUCT PREVIEW (IMAGE HOVER)
         ========================= */
            $itemsPreview = "
            <span class='table-imgname' data-bs-toggle='tooltip' data-bs-html='true'
                title=\"<img src='{$productImage}' style='width:120px;border-radius:8px'><br>
                       <strong>{$product?->name}</strong>\">
                <div style='display:flex; flex-direction:column; gap:4px;'>
                    <div><strong>{$product?->name}</strong></div>
                    <div class='product-sku'>Product ID: {$product?->product_id}</div>
                </div>
            </span>
        ";

            /* =========================
         | VARIANTS TOOLTIP
         ========================= */
            $variantHtml = $items->map(function ($item) {

                $color = $item->color?->name ?? 'Default';
                $size  = $item->size?->name ?? '-';

                $img = $item->product?->images->first()
                    ? R2Helper::getFileUrl($item->product->images->first()->image_path)
                    : asset('admin_assets/img/placeholder.jpg');

                return "<span class='d-inline-block mb-1'
                data-bs-toggle='tooltip' data-bs-html='true'
                title=\"<img src='{$img}' style='width:90px;border-radius:6px'><br>
                       <strong>Color:</strong> {$color}<br>
                       <strong>Size:</strong> {$size}<br>
                       <strong>Qty:</strong> {$item->quantity}\">
                <strong>{$color}</strong> {$size} × {$item->quantity}
            </span>";
            })->implode('<br>');

            /* =========================
         | TOTALS
         ========================= */
            $totalQty    = $items->sum('quantity');
            $totalAmount = $items->sum(fn($i) => $i->quantity * $i->price);

            /* =========================



            /* =========================
            | BANK SLIP
            ========================= */

            $bankSlipHtml = '<span class="text-muted">No Slip</span>';

            if ($order->attachments && $order->attachments->count()) {

                $attachment = $order->attachments->first();

                $url = R2Helper::getFileUrl($attachment->file_path);

                if (str_contains($attachment->mime_type, 'pdf')) {

                    $bankSlipHtml = "
            <a href='{$url}' target='_blank' class='btn btn-sm btn-outline-primary'>
                <i class='fa fa-download'></i> PDF
            </a>
        ";
                } else {

                    $bankSlipHtml = "
            <a href='{$url}' target='_blank'>
                <img src='{$url}' style='width:45px;height:45px;object-fit:cover;border-radius:6px'>
            </a>
        ";
                }
            }




            //  | PRODUCT STATUS LOGIC
            //  ========================= */
            $productStatus = match (true) {
                $items->every(fn($i) => $i->status === OrderItemStatus::DELIVERED) => OrderItemStatus::DELIVERED,
                $items->every(fn($i) => $i->status === OrderItemStatus::CANCELLED) => OrderItemStatus::CANCELLED,
                $items->contains(fn($i) => $i->status === OrderItemStatus::READYTODILIVER) => OrderItemStatus::READYTODILIVER,
                $items->contains(fn($i) => $i->status === OrderItemStatus::INPROGRESS) => OrderItemStatus::INPROGRESS,
                default => OrderItemStatus::PENDING,
            };

            /* =========================
         | STATUS BADGE
         ========================= */
            $statusBadge = match ($productStatus) {
                'pending' => '<span class="badge-pending">Pending</span>',
                'inprogress' => '<span class="badge-inactive">Inprogress</span>',
                'ready-to-deliver' => '<span class="badge-ready">Ready to deliver</span>',
                'delivered' => '<span class="badge-active">Delivered</span>',
                default => '<span class="badge-delete">Cancelled</span>',
            };

            /* =========================
         | ACTION SELECT
         ========================= */
            $action = "
            <div class='table-select'>
                <select class='select2 order-status-select'
                    data-order='{$order->id}'
                    data-product='{$productId}'>
                    <option value='pending' " . ($productStatus === OrderItemStatus::PENDING ? 'selected' : '') . ">Pending</option>
                    <option value='inprogress' " . ($productStatus === OrderItemStatus::INPROGRESS ? 'selected' : '') . ">Inprogress</option>
                    <option value='ready-to-deliver' " . ($productStatus === OrderItemStatus::READYTODILIVER ? 'selected' : '') . ">Ready to deliver</option>
                    <option value='cancelled' " . ($productStatus === OrderItemStatus::CANCELLED ? 'selected' : '') . ">Cancelled</option>
                </select>
            </div>
        ";

            /* =========================
         | FINAL ROW
         ========================= */
            $data[] = [
                'id'             => $order->id,
                'items_preview'  => $itemsPreview,
                'created_at'     => $order->created_at->format('d M Y H:i'),
                'customer_name'  => $order->address?->name ?? 'N/A',
                'address'        => $order->address
                    ? $order->address->address . ', ' . $order->address->city
                    : 'N/A',
                'phone'          => $order->address?->phone ?? '',
                'variants'       => $variantHtml,
                'count'          => $totalQty,
                'amount'         => 'LKR ' . number_format($totalAmount, 2),
                'bank_slip'      => $bankSlipHtml, // ✅ NEW
                'status'         => $statusBadge,
                'action'         => $action,
                'status_raw'     => $productStatus,
                'created_at_raw' => $order->created_at->timestamp,

            ];
        }

        return $data;
    }


    // public function buildOrderItemsData(Order $order)
    // {
    //     $order->load(['address', 'items.product.images', 'items.color', 'items.size']);

    //     $data = [];

    //     $groupedItems = $order->items->groupBy('product_id');

    //     foreach ($groupedItems as $productId => $items) {
    //         $product = $items->first()->product;

    //         $productImage = $product?->images->first()
    //             ? R2Helper::getFileUrl($product->images->first()->image_path)
    //             : asset('admin_assets/img/placeholder.jpg');

    //         $itemsPreview = "
    //     <span class='table-imgname' data-bs-toggle='tooltip' data-bs-html='true'
    //           title=\"<img src='{$productImage}' style='width:120px;border-radius:8px'><br>
    //                  <strong>{$product?->name}</strong>\">
    //         <div style='display:flex; flex-direction:column; gap:4px;'>
    //             <div><strong>{$product?->name}</strong></div>
    //             <div class='product-sku'>Product ID: {$product?->product_id}</div>
    //         </div>
    //     </span>";

    //         $variantHtml = $items->map(function ($item) {
    //             $color = $item->color?->name ?? 'Default';
    //             $size  = $item->size?->name ?? '-';
    //             $img = $item->product?->images->first()
    //                 ? R2Helper::getFileUrl($item->product->images->first()->image_path)
    //                 : asset('admin_assets/img/placeholder.jpg');

    //             return "<span data-bs-toggle='tooltip' data-bs-html='true'
    //             title=\"<img src='{$img}' style='width:90px;border-radius:6px'><br>
    //                    <strong>Color:</strong> {$color}<br>
    //                    <strong>Size:</strong> {$size}<br>
    //                    <strong>Qty:</strong> {$item->quantity}\">
    //             <strong>{$color}</strong> {$size} × {$item->quantity}
    //         </span>";
    //         })->implode('<br>');

    //         $totalQty = $items->sum('quantity');
    //         $totalAmount = $items->sum(fn($i) => $i->quantity * $i->price);

    //         // ✅ Determine PRODUCT status (not order status)
    //         $productStatus = match (true) {
    //             $items->every(fn($i) => $i->status === OrderItemStatus::DELIVERED)  => OrderItemStatus::DELIVERED,
    //             $items->every(fn($i) => $i->status === OrderItemStatus::CANCELLED)  => OrderItemStatus::CANCELLED,
    //             $items->contains(fn($i) => $i->status === OrderItemStatus::READYTODILIVER) => OrderItemStatus::READYTODILIVER,
    //             $items->contains(fn($i) => $i->status === OrderItemStatus::INPROGRESS) => OrderItemStatus::INPROGRESS,
    //             default => OrderItemStatus::PENDING,
    //         };

    //         // ✅ Badge HTML (UI stays same)
    //         $statusBadge = match ($productStatus) {
    //             'pending' => '<span class="badge-pending">Pending</span>',
    //             'inprogress' => '<span class="badge-inactive">Inprogress</span>',
    //             'ready-to-deliver' => '<span class="badge-ready">Ready to deliver</span>',
    //             'delivered' => '<span class="badge-active">Delivered</span>',
    //             default => '<span class="badge-delete">Cancelled</span>',
    //         };


    //         $action = "
    //     <div class='table-select'>
    //         <select class='select2 order-status-select'
    //             data-order='{$order->id}'
    //             data-product='{$productId}'>
    //             <option value='pending' " . ($productStatus === OrderItemStatus::PENDING ? 'selected' : '') . ">Pending</option>
    //             <option value='inprogress' " . ($productStatus === OrderItemStatus::INPROGRESS ? 'selected' : '') . ">Inprogress</option>
    //             <option value='ready-to-deliver' " . ($productStatus === OrderItemStatus::READYTODILIVER ? 'selected' : '') . ">Ready to deliver</option>
    //             <option value='delivered' " . ($productStatus === OrderItemStatus::DELIVERED ? 'selected' : '') . ">Delivered</option>
    //             <option value='cancelled' " . ($productStatus === OrderItemStatus::CANCELLED ? 'selected' : '') . ">Cancelled</option>
    //         </select>
    //     </div>";

    //         $data[] = [
    //             'id'             => $order->id,
    //             'items_preview'  => $itemsPreview,
    //             'created_at'     => $order->created_at->format('d M Y H:i'),
    //             'customer_name'  => $order->address?->name ?? 'N/A',
    //             'address'        => $order->address
    //                 ? $order->address->address . ', ' . $order->address->city
    //                 : 'N/A',
    //             'phone'          => $order->address?->phone ?? '',
    //             'variants'       => $variantHtml,
    //             'count'          => $totalQty,
    //             'amount'         => 'LKR ' . number_format($totalAmount, 2),
    //             'status'         => $statusBadge,
    //             'action'         => $action,
    //             'created_at_raw' => $order->created_at->timestamp,
    //         ];
    //     }

    //     return $data;
    // }





    public function ordersData(Request $request)
    {
        $orders = Order::with([
            'address',
            'items.product.images',
            'items.color',
            'items.size',
            'attachments',
        ])
            ->when($request->status && $request->status !== 'all', function ($q) use ($request) {
                $q->where('order_status', $request->status);
            })
            ->latest()
            ->get();

        $data = [];

        foreach ($orders as $order) {

            $groupedItems = $order->items->groupBy('product_id');
            $productCount = $groupedItems->count();
            $totalQty     = $order->items->sum('quantity');
            $totalAmount  = $order->items->sum(fn($i) => $i->price * $i->quantity);

            /* =========================
            | BANK SLIP
            ========================= */

            $bankSlipHtml = '<span class="text-muted">No Slip</span>';

            if ($order->attachments && $order->attachments->count()) {

                $attachment = $order->attachments->first();

                $url = R2Helper::getFileUrl($attachment->file_path);

                if (str_contains($attachment->mime_type, 'pdf')) {

                    $bankSlipHtml = "
            <a href='{$url}' target='_blank' class='btn btn-sm btn-outline-primary'>
                <i class='fa fa-download'></i> PDF
            </a>
        ";
                } else {

                    $bankSlipHtml = "
            <a href='{$url}' target='_blank'>
                <img src='{$url}' style='width:45px;height:45px;object-fit:cover;border-radius:6px'>
            </a>
        ";
                }
            }

            // ===== Check if ALL items are ready-to-deliver
            $allReadyToDeliver = $order->items->every(fn($i) => $i->status === OrderItemStatus::READYTODILIVER);

            /* STATUS BADGE */
            $statusBadge = match ($order->order_status) {
                'pending'    => '<span class="badge-pending">Pending</span>',
                'inprogress' => '<span class="badge-inactive">Inprogress</span>',
                'ready-to-deliver' => '<span class="badge-ready">Ready to deliver</span>',
                'delivered'  => '<span class="badge-active">Delivered</span>',
                default      => '<span class="badge-delete">Cancelled</span>',
            };

            /* ITEMS COLUMN */
            $firstGroup   = $groupedItems->first();
            $firstItem    = $firstGroup->first();
            $firstProduct = $firstItem->product;

            $productImg = $firstProduct?->images->first()
                ? R2Helper::getFileUrl($firstProduct->images->first()->image_path)
                : asset('admin_assets/img/placeholder.jpg');

            $itemsPreview = "
        <span data-bs-toggle='tooltip' data-bs-html='true'
              title=\"<img src='{$productImg}' style='width:120px;border-radius:8px'>\">
            <strong>{$firstProduct?->name}</strong><br>
            <small class='text-muted'>Product ID: {$firstProduct?->product_id}</small>
        </span>";

            if ($productCount > 1) {
                $itemsPreview .= "
            <div class='text-muted'>
                + " . ($productCount - 1) . " more product(s)
            </div>";
            }

            /* VARIANTS COLUMN */
            if ($productCount === 1) {
                $variants = $firstGroup->map(function ($item) {
                    $color = $item->color?->name ?? 'Default';
                    $size  = $item->size?->name ?? '-';
                    $img = $item->product?->images->first()
                        ? R2Helper::getFileUrl($item->product->images->first()->image_path)
                        : asset('admin_assets/img/placeholder.jpg');

                    return "<span data-bs-toggle='tooltip' data-bs-html='true'
                        title=\"<img src='{$img}' style='width:90px;border-radius:6px'><br>
                               <strong>Color:</strong> {$color}<br>
                               <strong>Size:</strong> {$size}<br>
                               <strong>Qty:</strong> {$item->quantity}\">
                        <strong>{$color}</strong> {$size} × {$item->quantity}
                    </span>";
                })->implode('<br>');
            } else {
                $variants = "{$productCount} product(s)";
            }

            /* ACTION COLUMN */
            /* =========================
          | ACTION COLUMN
            ========================= */
            $action = '';

            // If ALL products are ready-to-deliver, show message
            if ($allReadyToDeliver) {
                $action .= "<div class='text-success mb-1'>Products are ready to deliver</div>";
            }

            // Always show status dropdown if single product OR all ready-to-deliver
            if ($productCount === 1 || $allReadyToDeliver) {
                $productId = $allReadyToDeliver ? 'all' : $order->items->first()->product_id;
                $action .= "
    <div class='table-select'>
        <select class='select2 order-status-select'
            data-order='{$order->id}'
            data-product='{$productId}'>
            <option value='pending' " . (($order->order_status === 'pending') ? 'selected' : '') . ">Pending</option>
            <option value='inprogress' " . (($order->order_status === 'inprogress') ? 'selected' : '') . ">Inprogress</option>
            <option value='ready-to-deliver' " . (($order->order_status === 'ready-to-deliver') ? 'selected' : '') . ">Ready to deliver</option>
            <option value='delivered' " . (($order->order_status === 'delivered') ? 'selected' : '') . ">Delivered</option>
            <option value='cancelled' " . (($order->order_status === 'cancelled') ? 'selected' : '') . ">Cancelled</option>
        </select>
    </div>";
            }

            // Always show "See more items" button if multiple products
            if ($productCount > 1) {
                $action .= "<a href='" . route('admin.orders.items', $order->id) . "'
               class='btn btn-sm btn-outline-primary mt-1'>
               See more items ({$productCount})
            </a>";
            }

            $customerName  = $order->address?->name ?? 'N/A';
            $customerEmail = $order->address?->email ?? '';

            $customerNameHtml = e($customerName);
            if ($customerEmail !== '') {
                $customerNameHtml = "<span class='customer-email-wrap'><span class='customer-email-name'>" . e($customerName) . "</span><span class='customer-email-popup'><span class='email-label'>Email</span><span class='email-value'>" . e($customerEmail) . "</span><button type='button' class='btn btn-sm btn-outline-primary copy-email-btn' data-email='" . e($customerEmail) . "'>Copy</button></span></span>";
            }


            $data[] = [
                'id'             => $order->order_number,
                'items_preview'  => $itemsPreview,
                'created_at'     => $order->created_at->format('d M Y H:i'),
                'customer_name'  => $customerNameHtml,
                'customer_email' => $customerEmail ?: 'N/A',
                'address'        => $order->address
                    ? $order->address->address . ', ' . $order->address->city
                    : 'N/A',
                'phone'          => $order->address?->phone ?? '',
                'variants'       => $variants,
                'count'          => $totalQty,
                'amount'         => 'LKR ' . number_format($totalAmount, 2),
                'bank_slip'      => $bankSlipHtml,
                'status'         => $statusBadge,
                'action'         => $action,
                'created_at_raw' => $order->created_at->timestamp,
            ];
        }

        return response()->json(['data' => $data]);
    }
























    // public function ordersData(Request $request)
    // {
    //     $orders = Order::with([
    //         'address',
    //         'items.product.images',
    //         'items.color',
    //         'items.size'
    //     ])
    //         ->when($request->status && $request->status !== 'all', function ($q) use ($request) {
    //             $q->where('order_status', $request->status);
    //         })
    //         ->latest()
    //         ->get();

    //     $data = [];

    //     foreach ($orders as $order) {

    //         $groupedItems = $order->items->groupBy('product_id');

    //         $productCount = $groupedItems->count();
    //         $totalQty     = $order->items->sum('quantity');
    //         $totalAmount  = $order->items->sum(fn($i) => $i->price * $i->quantity);

    //         /* =========================
    //      | STATUS BADGE (UNCHANGED)
    //      ========================= */
    //         $statusBadge = match ($order->order_status) {
    //             'pending'    => '<span class="badge-pending">Pending</span>',
    //             'inprogress' => '<span class="badge-inactive">Inprogress</span>',
    //             'delivered'  => '<span class="badge-active">Delivered</span>',
    //             default      => '<span class="badge-delete">Cancelled</span>',
    //         };

    //         /* =========================
    //      | ITEMS + VARIANTS
    //      ========================= */
    //         $firstGroup   = $groupedItems->first();
    //         $firstItem    = $firstGroup->first();
    //         $firstProduct = $firstItem->product;

    //         $productImg = $firstProduct?->images->first()
    //             ? R2Helper::getFileUrl($firstProduct->images->first()->image_path)
    //             : asset('admin_assets/img/placeholder.jpg');

    //         /* ---------- ITEMS COLUMN ---------- */
    //         $itemsPreview = "
    //         <span data-bs-toggle='tooltip' data-bs-html='true'
    //               title=\"<img src='{$productImg}' style='width:120px;border-radius:8px'>\">
    //             <strong>{$firstProduct?->name}</strong><br>
    //             <small class='text-muted'>
    //                 Product ID: {$firstProduct?->product_id}
    //             </small>
    //         </span>
    //     ";

    //         if ($productCount > 1) {
    //             $itemsPreview .= "
    //             <div class='text-muted'>
    //                 + " . ($productCount - 1) . " more product(s)
    //             </div>
    //         ";
    //         }

    //         /* ---------- VARIANTS COLUMN ---------- */
    //         if ($productCount === 1) {
    //             // SINGLE PRODUCT → SHOW VARIANTS WITH TOOLTIP
    //             $variants = $firstGroup->map(function ($item) {
    //                 $color = $item->color?->name ?? 'Default';
    //                 $size  = $item->size?->name ?? '-';

    //                 $img = $item->product?->images->first()
    //                     ? R2Helper::getFileUrl($item->product->images->first()->image_path)
    //                     : asset('admin_assets/img/placeholder.jpg');

    //                 return "<span data-bs-toggle='tooltip' data-bs-html='true'
    //                 title=\"<img src='{$img}' style='width:90px;border-radius:6px'><br>
    //                        <strong>Color:</strong> {$color}<br>
    //                        <strong>Size:</strong> {$size}<br>
    //                        <strong>Qty:</strong> {$item->quantity}\">
    //                 <strong>{$color}</strong> {$size} × {$item->quantity}
    //             </span>";
    //             })->implode('<br>');
    //         } else {
    //             // MULTIPLE PRODUCTS
    //             $variants = "{$productCount} product(s)";
    //         }

    //         /* =========================
    //      | ACTION LOGIC (UNCHANGED)
    //      ========================= */
    //         if ($productCount > 1) {
    //             $action = "
    //             <a href='" . route('admin.orders.items', $order->id) . "'
    //                class='btn btn-sm btn-outline-primary'>
    //                See more items ({$productCount})
    //             </a>";
    //         } else {
    //             $productId = $order->items->first()->product_id;

    //             $action = "
    //         <div class='table-select'>
    //             <select class='select2 order-status-select'
    //                 data-order='{$order->id}'
    //                 data-product='{$productId}'>
    //                 <option value='pending'>Pending</option>
    //                 <option value='inprogress'>Inprogress</option>
    //                 <option value='delivered'>Delivered</option>
    //                 <option value='cancelled'>Cancelled</option>
    //             </select>
    //         </div>";
    //         }

    //         /* =========================
    //      | FINAL DATA ROW
    //      ========================= */
    //         $data[] = [
    //             'id'             => $order->order_number,
    //             'items_preview'  => $itemsPreview,
    //             'created_at'     => $order->created_at->format('d M Y H:i'),
    //             'customer_name'  => $order->address?->name ?? 'N/A',
    //             'address'        => $order->address
    //                 ? $order->address->address . ', ' . $order->address->city
    //                 : 'N/A',
    //             'phone'          => $order->address?->phone ?? '',
    //             'variants'       => $variants,
    //             'count'          => $totalQty,
    //             'amount'         => 'LKR ' . number_format($totalAmount, 2),
    //             'status'         => $statusBadge,
    //             'action'         => $action,
    //             'created_at_raw' => $order->created_at->timestamp,
    //         ];
    //     }

    //     return response()->json(['data' => $data]);
    // }


    public function updateItemsStatus(Request $request)
    {
        $request->validate([
            'order_id'   => 'required|integer',
            'product_id' => 'required|integer',
            'status'     => 'required|string',
        ]);

        OrderItem::where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->update(['status' => $request->status]);

        $order = Order::with('items')->findOrFail($request->order_id);

        $statuses = $order->items->pluck('status')->unique()->values()->toArray();

        if (count($statuses) === 1 && $statuses[0] === OrderItemStatus::DELIVERED) {
            $order->order_status = OrderItemStatus::DELIVERED;
        } elseif (count($statuses) === 1 && $statuses[0] === OrderItemStatus::CANCELLED) {
            $order->order_status = OrderItemStatus::CANCELLED;
        } elseif (in_array(OrderItemStatus::READYTODILIVER, $statuses)) {
            $order->order_status = OrderItemStatus::READYTODILIVER;
        } elseif (in_array(OrderItemStatus::INPROGRESS, $statuses)) {
            $order->order_status = OrderItemStatus::INPROGRESS;
        } else {
            $order->order_status = OrderItemStatus::PENDING;
        }

        $order->save();

        // ✅ RETURN UPDATED TABLE DATA
        $data = $this->buildOrderItemsData($order);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => $data
        ]);
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'status'   => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::with(['items', 'address', 'items.product.images'])->findOrFail($request->order_id);

            // ✅ Update order status
            $order->order_status = $request->status;
            $order->save();

            // ✅ Update all order items to match status if delivered
            if ($request->status === 'delivered') {
                foreach ($order->items as $item) {
                    $item->status = 'delivered';
                    $item->save();
                }

                // ✅ Dispatch email job
                dispatch(new SendOrderDeliveredEmail($order));
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Order and items status updated successfully'
        ]);
    }



    // public function updateItemsStatus(Request $request)
    // {
    //     $request->validate([
    //         'order_id'   => 'required|integer',
    //         'product_id' => 'required|integer',
    //         'status'     => 'required|string',
    //     ]);

    //     $orderId   = $request->order_id;
    //     $productId = $request->product_id;
    //     $status    = $request->status;

    //     // ✅ Update ALL variants of the same product in this order
    //     OrderItem::where('order_id', $orderId)
    //         ->where('product_id', $productId)
    //         ->update([
    //             'status' => $status
    //         ]);

    //     // ✅ Recalculate order status based on all items
    //     $order = Order::with('items')->findOrFail($orderId);

    //     $statuses = $order->items->pluck('status')->unique()->values()->toArray();

    //     // Logic to update order_status automatically
    //     if (count($statuses) === 1 && $statuses[0] === OrderItemStatus::DELIVERED) {
    //         $order->order_status = OrderItemStatus::DELIVERED;
    //     } elseif (count($statuses) === 1 && $statuses[0] === OrderItemStatus::CANCELLED) {
    //         $order->order_status = OrderItemStatus::CANCELLED;
    //     } elseif (in_array(OrderItemStatus::READYTODILIVER, $statuses)) {
    //         $order->order_status = OrderItemStatus::READYTODILIVER;
    //     } elseif (in_array(OrderItemStatus::INPROGRESS, $statuses)) {
    //         $order->order_status = OrderItemStatus::INPROGRESS;
    //     } else {
    //         $order->order_status = OrderItemStatus::PENDING;
    //     }

    //     $order->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Order item status updated successfully'
    //     ]);
    // }




    // public function updateItemsStatus(Request $request)
    // {
    //     $request->validate([
    //         'order_id'   => 'required|exists:orders,id',
    //         'product_id' => 'required|exists:products,id',
    //         'status'     => 'required|in:pending,inprogress,delivered,cancelled'
    //     ]);

    //     DB::transaction(function () use ($request) {

    //         // 1️⃣ Update ONLY items of this product
    //         OrderItem::where('order_id', $request->order_id)
    //             ->where('product_id', $request->product_id)
    //             ->update(['status' => $request->status]);

    //         // 2️⃣ Refresh order status + mail logic
    //         $order = Order::with('items')->findOrFail($request->order_id);
    //         $order->refreshStatusFromItems();
    //     });

    //     return response()->json(['success' => true]);
    // }
}
