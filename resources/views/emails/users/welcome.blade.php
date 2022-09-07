@component('mail::message')
# Connexion reussie


Bienvenue sur l'appication Fyatu.

@component('mail::button', ['url' => ''])
Se deconnecter
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
