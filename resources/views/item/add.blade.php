@extends('adminlte::page')

@section('title', 'モノ登録')

@section('content_header')
    <h1>モノ登録</h1>
@stop

@section('content')

    <!-- 1つ前に戻るボタン -->
    <button type="button"  class="btn btn-light mb-2" onClick="history.back()">◀︎ 一覧画面に戻る</button>

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
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="name">エリア</label>
                            <select name="area" data-toggle="select" class="form-control">
                                <option value="" {{ old('area') == isset($area) ? "selected":"" }}>未選択</option>
                                <option value="0" {{ old('area') == "0" ? "selected":"" }}>リビング</option>
                                <option value ="1" {{ old('area') == "1" ? "selected":"" }}>寝室</option>
                                <option value="2" {{ old('area') == "2" ? "selected":"" }}>キッチン</option>
                                <option value="3" {{ old('area')  == "3" ? "selected":"" }}>玄関</option>
                                <option value="4" {{ old('area')  == "4" ? "selected":"" }}>トイレ・バス</option>
                                <option value="5" {{ old('area')  == "5" ? "selected":"" }}>その他</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">分類</label>
                            <select name="type" data-toggle="select" class="form-control">
                                <option value="" {{ old('type') == isset($type) ? "selected":"" }}>未選択</option>
                                <option value="0" {{ old('type')  == "0" ? "selected":"" }}>必要</option>
                                <option value ="1" {{ old('type')  == "1" ? "selected":"" }}>大切</option>
                                <option value="2" {{ old('type')  == "2" ? "selected":"" }}>保留</option>
                            </select>
                        </div>

                        <div class="form-group col-2">
                            <label for="purchasedate">購入日</label>
                            <input type="date" data-input class="form-control" id="purchasedate" name="purchasedate" placeholder="購入日" value="{{ old('purchasedate') }}">
                        </div>

                        <div class="form-group">
                            <label for="detail">メモ</label>
                            <textarea class="form-control" id="detail" name="detail" placeholder="メモ">{{ old('detail') }}</textarea>
                        </div>
                    </div>
            </div>

                    <button type="submit" class="btn btn-primary">登録</button>

                </form>

        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
