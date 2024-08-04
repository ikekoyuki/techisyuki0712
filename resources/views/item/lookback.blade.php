@extends('adminlte::page')

@section('title', '捨てたモノ振り返り')

@section('content_header')
    <h1>捨てたモノ振り返り</h1>
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
                    <h3 class="card-title">捨てたモノ一覧</h3>
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
                                <th>捨てた日</th>
                                <th>メモ</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ \App\Models\Item::Area[$item->area] }}</td>
                                    <td>{{ $item->dumpdate }}</td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $item->detail }}</td>

                                    <!-- ボタン -->
                                    <td class="text-right">
                                    <a href="{{ url('items/edit',$item->id) }}" class="btn btn-primary btn-sm mr-3">編集</a>
                                    <a href="{{ url('items/undo',$item->id) }}" class="btn btn-secondary btn-sm mr-3">保留に変更</a>
                                    <a href="{{ url('items/delete',$item->id) }}" class="btn btn-danger btn-sm mr-3">削除</a>
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
