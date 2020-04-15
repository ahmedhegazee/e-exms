@component('mail::message')
# Introduction
<strong>Dear, {{$full_name}}</strong>
<p>{{$message}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
