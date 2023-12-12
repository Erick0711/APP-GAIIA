@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-blog')
                                <a href="{{ route('blogs.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-responsive table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <tr>
                                        <th style="display: none">ID</th>
                                        <th style="color: white">TITULO</th>
                                        <th style="color: white">CONTENIDO</th>
                                        <th style="color: white">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                    <tr>
                                        <td style="display: none">{{$blog->id}}</td>
                                        <td>{{$blog->titulo}}</td>
                                        <td>{{$blog->contenido}}</td>
                                        <td>
                                            @can('editar-blog')
                                                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-Primary">Editar</a>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('borrar-blog')
                                            <a class="btn btn-info" href="{{ route('blogs.edit', $blog->id)}}">Editar</a>
                                            {!! Form::open(['method'=> 'DELETE', 'route'=>['roles.destroy',$blog->id], 'style'=>'display:inline']) !!}
                                                {!! Form::submit('Borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $blogs->links() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

