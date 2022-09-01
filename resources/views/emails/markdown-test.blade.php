@component('mail::message')
# Nouvelle connection sur votre compte

Bonjour {{$data->email}}.


@component('mail::button', ['url' => $url, 'color' => 'success'])
Cliquez Ici
@endcomponent
pour Valider votre Autentification <br> <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
