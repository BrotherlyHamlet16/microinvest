<x-mail::message>
# Withdrawal Successful

Hi {{ $investment->user->name }},

You've successfully withdrawn your investment from **{{ $investment->plan->name }}**.

- **Total Amount Received**: {{ number_format($total, 2) }}

We hope to see you invest again soon!

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
