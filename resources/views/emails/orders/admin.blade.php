@component('mail::message')
# New Order Received

**Customer Details**

@component('mail::table')
|              |                            |
|--------------|----------------------------|
| **Customer** | {{ $customer['name'] }}    |
| **Email**    | {{ $customer['email'] }}   |
| **Phone**    | {{ $customer['phone'] }}   |
@endcomponent

@component('mail::table')
| Product ID | Product Name                                 | Qty   | Size | Color | Price    |
|-----------:|:-----------------------------------:|:-----:|:-------:|:----------:|---------:|
@foreach ($orderItems as $item)
| {{ $item['product_id'] }} | {{ $item['title'] }} | {{ $item['quantity'] }} | {{ $item['size'] ?? '-' }} | {{ $item['color'] ?? '-' }} | {{ number_format($item['price'], 2) }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => $adminLink])
View in Admin Dashboard
@endcomponent

@endcomponent
