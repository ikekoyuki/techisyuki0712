@extends('adminlte::page')

@section('title', 'モノ編集')

@section('content_header')
    <h1>モノ編集</h1>
@stop

@section('content')

    <!-- モノ編集フォーム -->

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
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{ $item->name }}">
                        </div>

                        <div class="form-group">
                            <label for="name">エリア</label>
                            <select name="area" data-toggle="select" class="form-control">
                                <option value="" {{ isset($item->area) ? "selected":"" }}>未選択</option>
                                <option value="0" {{ $item->area == "0" ? "selected":"" }}>リビング</option>
                                <option value ="1" {{ $item->area == "1" ? "selected":"" }}>寝室</option>
                                <option value="2" {{ $item->area == "2" ? "selected":"" }}>キッチン</option>
                                <option value="3" {{ $item->area == "3" ? "selected":"" }}>玄関</option>
                                <option value="4" {{ $item->area == "4" ? "selected":"" }}>トイレ・バス</option>
                                <option value="5" {{ $item->area == "5" ? "selected":"" }}>その他</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">分類</label>
                            <select name="type" data-toggle="select" class="form-control">
                                <option value="" {{ isset($item->type) ? "selected":"" }}>未選択</option>
                                <option value="0" {{ $item->type == "0" ? "selected":"" }}>必要</option>
                                <option value ="1" {{ $item->type == "1" ? "selected":"" }}>大切</option>
                                <option value="2" {{ $item->type == "2" ? "selected":"" }}>保留</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明" value="{{ $item->detail }}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">編集</button>
                    </div>
                </form>

                <a href="/items/dump/{{$item->id}}">
                    <button type="button" class="btn btn-outline-secondary mt-3 ms-3">捨てる</button>


                <a href="/items/delete/{{$item->id}}">
                    <button type="button" class="btn btn-outline-secondary mt-3 ms-3">削除</button>

            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
