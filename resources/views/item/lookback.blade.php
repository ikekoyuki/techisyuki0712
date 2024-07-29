@extends('adminlte::page')

@section('title', '捨てたモノ一覧')

@section('content_header')
    <h1>捨てたモノ一覧</h1>
@stop

@section('content')
    <form action="{{ route('lookback') }}" method="GET">

        <div class="row">

            <!-- 名前で検索 -->
            <div class="col-lg-3 mb-3">
                <input class="form-control form-control-sm " type="text" name="name" value="{{ $name }}" placeholder="名前">
            </div>

            <!-- エリアで検索 -->
            <div class="col-6 col-lg-2 mb-3">
                <select name="area" class="form-control form-control-sm" aria-label="Default select example">
                    <option value="" {{ isset($area) ? "selected":"" }}>エリア</option>
                    <option value="0" {{ $area == "0" ? "selected":"" }}>リビング</option>
                    <option value="1" {{ $area == "1" ? "selected":"" }}>寝室</option>
                    <option value="2" {{ $area == "2" ? "selected":"" }}>キッチン</option>
                    <option value="3" {{ $area == "3" ? "selected":"" }}>玄関</option>
                    <option value="4" {{ $area == "4" ? "selected":"" }}>トイレ・バス</option>
                    <option value="4" {{ $area == "5" ? "selected":"" }}>その他</option>
                </select>
            </div>

            <!-- 分類で検索 -->
            <div class="col-6 col-lg-2 mb-3">
                <select name="type" class="form-control form-control-sm" aria-label="Default select example">
                    <option value="" {{ isset($type) ? "selected":"" }}>分類</option>
                    <option value="0" {{ $type == "0" ? "selected":"" }}>必要</option>
                    <option value="1" {{ $type == "1" ? "selected":"" }}>大切</option>
                    <option value="2" {{ $type == "2" ? "selected":"" }}>保留</option>
                </select>
            </div>

            <div class="col-lg-3 d-flex align-items-end">

            <!-- 検索ボタン -->
                <input type="submit" value="検索" class="btn btn-default btn-sm mb-3 ms-3" style="margin-right: 5px;">

            <!-- リセットボタン -->
                <a href="{{ url('items') }}" class="btn btn-default btn-sm mb-3 ms-3">リセット</a>

            </div>

        </div>

    </form>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">モノ一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>エリア</th>
                                <th>分類</th>
                                <th>メモ</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ \App\Models\Item::Area[$item->area] }}</td>
                                    <td>{{ \App\Models\Item::Type[$item->type] }}</td>
                                    <td>{{ $item->detail }}</td>

                                    <!-- 削除ボタン -->
                                    <td>
                                    <a href="/items/delete/{{$item->id}}">
                                        <button type="button" class="btn btn-default btn-sm">削除</button>
                                    </td>
                                    <td>
                                        <a href="/items/undo/{{$item->id}}">
                                            <button type="button" class="btn btn-default btn-sm">元に戻す</button>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@stop

@section('css')
@stop

@section('js')
@stop
