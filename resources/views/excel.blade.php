<table>
    <tr><td>Contract</td></tr>
    <tr>
        <td>subject</td>
        <td>provider</td>
        <td>price</td>
        <td>prepayment</td>
        <td>total payment</td>
        <td>created at</td>
        <td>expire at</td>
        <td>contract number</td>
        <td>status</td>
    </tr>
    <tr>
        <td>{{ $contract['subject'] }}</td>
        <td>{{ $contract['provider'] }}</td>
        <td>{{ $contract['price'] }}</td>
        <td>{{ $contract['prepayment'] }}</td>
        <td>{{ $contract['total_payment'] }}</td>
        <td>{{ $contract['created_at'] }}</td>
        <td>{{ $contract['expires_at'] }}</td>
        <td>{{ $contract['contract_number'] }}</td>
        <td>{{ $contract['status'] }}</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr><td>Payments</td></tr>
    @foreach($contract['payment'] as $payment)
    <tr></tr>
    <tr>
        <td>payment number</td>
        <td>billing month</td>
        <td>prepayment</td>
        <td>total</td>
    </tr>
    <tr>
        <td>{{ $payment['payment_number'] }}</td>
        <td>{{ $payment['billing_month'] }}</td>
        <td>{{ $payment['prepayment'] }}</td>
        <td>{{ $payment['total'] }}</td>
    </tr>
    @endforeach
</table>

