<x-mail::message>
# Investment Confirmed

Hi {{$investment->user->name}},

You've successfully invested **{{ number_format($investment->amount, 2) }}** in the plan **{{ $investment->plan->name }}**.

- **Start Date**: {{ $investment->start_date->toFormattedDateString() }}
- **Maturity Date**: {{ $investment->maturity_date->toFormattedDateString() }}

Thank you for trusting us.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
