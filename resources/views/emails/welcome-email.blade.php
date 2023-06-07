@component('mail::message')
# Hi {{$first_name}}!

Welcome aboard! We are looking forward to working with you.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
