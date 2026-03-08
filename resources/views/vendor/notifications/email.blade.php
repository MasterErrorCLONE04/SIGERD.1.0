<x-mail::message>
    {{-- Greeting --}}
    # ¡Hola!

    Has recibido este correo porque se realizó una solicitud de restablecimiento de contraseña para tu cuenta en
    **SIGERD**.

    {{-- Action Button --}}
    @isset($actionText)
        <x-mail::button :url="$actionUrl" color="primary">
            Restablecer Contraseña
        </x-mail::button>
    @endisset

    Este enlace de restablecimiento expirará en 60 minutos.

    Si no solicitaste un cambio de contraseña, puedes ignorar este mensaje. Tu cuenta permanece segura.

    Saludos,<br>
    **Equipo SIGERD**

    {{-- Subcopy --}}
    @isset($actionText)
        <x-slot:subcopy>
            Si tienes problemas al hacer clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu
            navegador: <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
        </x-slot:subcopy>
    @endisset
</x-mail::message>