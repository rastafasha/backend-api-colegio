@component('mail::message')
# Notificación de Matrícula

Estimado/a {{ $student->parent->name }},

Le informamos que la matrícula del estudiante **{{ $student->name }} {{ $student->surname }}** con número de matrícula **{{ $student->matricula }}** está registrada en el sistema.

Gracias por su atención.

Saludos,  
Sistema Automatizado de Envío de Notificaciones
@endcomponent
