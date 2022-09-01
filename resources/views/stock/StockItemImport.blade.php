@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Import Excel</div>
                    <div class=" card-body">
                        @if(session('status'))
                            <div class=" alert alert-success">
                                {{ session('status')}}
                            </div>
                        @endif
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="file" id="">
                                <button type="submit" class=" btn btn-primary"></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    
@endsection