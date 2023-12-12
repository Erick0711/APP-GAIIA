@extends('layouts.app')

@section('content')
<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        {{-- <h5 class="my-3">{{ $persona->nombre_pers }}</h5> --}}
                        {{-- <p class="text-muted mb-4">{{ $persona->ci_pers }}{{ $persona->complemento_ci_pers }}-{{ $persona->expedido_pers }}</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Nombre:</p>
                            </div>
                            <div class="col-sm-9">
                                {{-- <p class="text-muted mb-0">{{$persona->nombre_pers}} {{$persona->apellido_pers}}</p> --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Correo:</p>
                            </div>
                            <div class="col-sm-9">
                                {{-- <p class="text-muted mb-0">{{$persona->correo_pers}}</p> --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Teléfono:</p>
                            </div>
                            <div class="col-sm-9">
                                {{-- <p class="text-muted mb-0">{{$persona->telefono_pers}} {{$persona->telefono2_pers != "" ? "-" . $persona->telefono2_pers : ""}}</p> --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Lugar Nac:</p>
                            </div>
                            <div class="col-sm-9">
                                {{-- <p class="text-muted mb-0">{{$persona->id_pais}} - {{$persona->departamento_nac_pers}} {{$persona->provincia_nac_pers}}</p> --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Domicilio</p>
                            </div>
                            <div class="col-sm-9">
                                {{-- <p class="text-muted mb-0">{{$persona->domicilio_pers}}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                        <p class="mb-4"><span class="text-primary font-italic me-1">Curriculum Capitular</span>
                        </p>
                        @foreach ($pagos as $pago)
                            <p class="mb-1" style="font-size: .77rem;">{{$pago->articulo->gestion->anio_gest}}</p>
                            <div class="progress rounded" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>   
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                        <p class="mb-4"><span class="text-primary font-italic me-1">Estado Economico</span>
                        </p>
                        <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                        <div class="progress rounded" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
