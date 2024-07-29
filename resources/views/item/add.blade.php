@extends('adminlte::page')

@section('title', 'モノ登録')

@section('content_header')
    <h1>モノ登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                        </div>

                        <div class="form-group">
                            <label for="name">エリア</label>
                            <select name="area" data-toggle="select" class="form-control">
                                <option value="">未選択</option>
                                <option value="0">リビング</option>
                                <option value ="1">寝室</option>
                                <option value="2">キッチン</option>
                                <option value="3">玄関</option>
                                <option value="4">トイレ・バス</option>
                                <option value="5">その他</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">分類</label>
                            <select name="type" data-toggle="select" class="form-control">
                                <option value="">未選択</option>
                                <option value="0">必要</option>
                                <option value ="1">大切</option>
                                <option value="2">保留</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
