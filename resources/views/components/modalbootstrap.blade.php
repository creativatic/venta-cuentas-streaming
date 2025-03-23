@props([
    'id',
    'title' => '',
    'size' => 'modal-lg',
    'staticBackdrop' => false
])

<div
    x-data="{ show: false }"
    x-init="
        $watch('show', value => {
            if (value) {
                document.body.classList.add('modal-open');
                document.body.style.overflow = 'hidden';
                document.body.style.paddingRight = '15px';
                $el.classList.add('show');
                $el.style.display = 'block';
                
                // Crear el backdrop si no existe
                if (!document.querySelector('.modal-backdrop')) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
                
                setTimeout(() => {
                    $el.querySelector('.modal-dialog').classList.add('show');
                }, 50);
            } else {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Eliminar el backdrop inmediatamente
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                
                // Reducir el tiempo de espera para cerrar el modal
                setTimeout(() => {
                    $el.classList.remove('show');
                    $el.style.display = 'none';
                }, 150); // Reducido de 300ms a 150ms
            }
        })
    "
    x-on:open-modal.window="if ($event.detail == '{{ $id }}') show = true"
    x-on:close-modal.window="if ($event.detail == '{{ $id }}') show = false"
    x-on:keydown.escape.window="show = false"
    @if(!$staticBackdrop)
    x-on:click.self="show = false"
    @endif
    class="modal fade"
    id="{{ $id }}"
    tabindex="-1"
    aria-labelledby="{{ $id }}Label"
    aria-hidden="true"
>
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            @if($title)
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" x-on:click="show = false" aria-label="Close"></button>
            </div>
            @endif
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Estilos para el backdrop */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 20);
    }
    
    .modal-backdrop.fade {
        opacity: 0;
        transition: opacity 0.15s linear;
    }
    
    .modal-backdrop.show {
        opacity: 0.5;
    }
    
    /* Asegurarse de que el modal aparezca sobre el backdrop */
    .modal {
        z-index: 1050;
    }
    
    /* Acelerar las transiciones */
    .modal.fade .modal-dialog {
        transition: transform 0.5s ease-out;
    }
</style>