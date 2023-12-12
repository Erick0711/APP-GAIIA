@extends('layouts.app')
{{-- style="background-color: #8e898973" --}}
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" >
                        <div class="card-body mx-auto">
                            @can('crear-rol')
                                <a href="{{ route('roles.create') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                            @endcan
                            
                            <table class="table table-responsive table-striped mt-2">
                                <thead style="background-color: #3c3f5a;">
                                    <tr>
                                        <th style="color: white">ROL</th>
                                        <th style="color: white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $rol)
                                    <tr>
                                        <td style="display: none">{{$rol->id}}</td>
                                        <td>{{$rol->name}}</td>
                                        <td class="text-center">
                                            @can('editar-rol')
                                                <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('borrar-rol')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $rol->id], 'style' => 'display:inline']) !!}
                                            @if($rol->estado_roles == 0)
                                            {!! Form::button('<i class="fas fa-history"></i>', ['class' => "btn btn-sm btn-primary", 'type' => 'submit', 'onclick' => 'return confirmReset(event, this)']) !!}
                                            @else
                                            {!! Form::button('<i class="fas fa-trash-alt"></i>', ['class' => "btn btn-sm btn-danger", 'type' => 'submit', 'onclick' => 'return confirmDelete(event, this)']) !!}
                                            @endif
                                                
                                            
                                            {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $roles->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function confirmDelete(event, button) {
        event.preventDefault();

        const confirmMessage = $(button).closest('form').data('confirm');

        Swal.fire({
            title: "¿Deseas Eliminar este Rol?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            timer: 2000, // Tiempo en milisegundos
            timerProgressBar: true,
            timerProgressBarColor: '#007bff' // Color de la barra de progreso
        }).then((result) => {
            if (result.isConfirmed) {
                $(button).closest('form').submit();
            }
        });
    }

    function confirmReset(event, button) {
        event.preventDefault();

        const confirmMessage = $(button).closest('form').data('confirm');

        Swal.fire({
            title: "¿Deseas Restaurar este Rol?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            timer: 2000, // Tiempo en milisegundos
            timerProgressBar: true,
            timerProgressBarColor: '#007bff' // Color de la barra de progreso
        }).then((result) => {
            if (result.isConfirmed) {
                $(button).closest('form').submit();
            }
        });
    }
</script>
    
@endsection



