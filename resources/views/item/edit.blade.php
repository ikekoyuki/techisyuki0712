@extends('adminlte::page')

@section('title', 'モノ編集')

@section('content_header')
    <h1>モノ編集</h1>
@stop

@section('content')

    <!-- モノ編集フォーム -->

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
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group col-12">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{ old('name', $item->name) }}">
                        </div>

                        <div class="form-group col-12">
                            <label for="name">エリア</label>
                            <select name="area" data-toggle="select" class="form-control">
                                <option value="" {{ old('area',$item->area) == isset($item->area) ? "selected":"" }}>未選択</option>
                                <option value="0" {{ old('area',$item->area) == "0" ? "selected":"" }}>リビング</option>
                                <option value ="1" {{ old('area',$item->area) == "1" ? "selected":"" }}>寝室</option>
                                <option value="2" {{ old('area',$item->area) == "2" ? "selected":"" }}>キッチン</option>
                                <option value="3" {{ old('area',$item->area) == "3" ? "selected":"" }}>玄関</option>
                                <option value="4" {{ old('area',$item->area) == "4" ? "selected":"" }}>トイレ・バス</option>
                                <option value="5" {{ old('area',$item->area) == "5" ? "selected":"" }}>その他</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="type">分類</label>
                            <select name="type" data-toggle="select" class="form-control">
                                <option value="" {{ old('area',$item->area) == isset($item->type) ? "selected":"" }}>未選択</option>
                                <option value="0" {{ old('type',$item->type) == "0" ? "selected":"" }}>必要</option>
                                <option value ="1" {{ old('type',$item->type) == "1" ? "selected":"" }}>大切</option>
                                <option value="2" {{ old('type',$item->type) == "2" ? "selected":"" }}>保留</option>

                                @if($item->type == "3")
                                    <option value="3" {{ old('type',$item->type) == "3" ? "selected":"" }}>捨てる</option>
                                @else
                                @endif

                            </select>
                        </div>

                        <div class="form-group col-2">
                            <label for="purchasedate">購入日</label>
                            <input type="date" data-input class="form-control" id="purchasedate" name="purchasedate" placeholder="購入日" value="{{ old('purchasedate', $item->purchasedate) }}">
                        </div>

                        @if($item->type != "3")
                        @else
                        <div class="form-group col-2">
                            <label for="dumpdate">捨てた日</label>
                            <input type="date" data-input class="form-control" id="dumpdate" name="dumpdate" placeholder="捨てた日" value="{{ old('dumpdate', $item->dumpdate) }}">
                        </div>
                        @endif

                        <div class="form-group col-12">
                            <label for="detail">メモ</label>
                            <textarea class="form-control" id="detail" name="detail" placeholder="メモ">{{ old('detail', $item->detail) }}</textarea>
                        </div>


                    <!-- 画像アップロード -->
                    <div class="form-group col-12">
                        <label for="image">画像</label>
                        <br>
                        <input class="mb-3" type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        <br>
                        <!-- 画像プレビュー -->
                        @if(!empty($item->image))
                            <img id="imagePreview" src="data:image/png;base64,{{ $item->image }}" style="width: 30%; height: auto;">
                        @else
                            <img id="imagePreview" style="width: 30%; height: auto; display: none;">
                        @endif
                    </div>

                    <!-- JavaScriptによるプレビュー処理 -->
                    <script>
                        function previewImage(event) {
                            var reader = new FileReader();
                            reader.onload = function(){
                                var output = document.getElementById('imagePreview');
                                output.src = reader.result;
                                output.style.display = 'block';
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    </script>

                </div>
            </div>

                    <button type="submit" class="btn btn-primary mr-3">編集</button>
                </form>

                @if($item->type == "3")
                @else
                <a href="/items/dump/{{$item->id}}">
                    <button type="button" class="btn btn-success mr-3">捨てる</button>
                </a>
                @endif

                <a href="/items/delete/{{$item->id}}">
                    <button type="button" class="btn btn btn-danger" onclick='return confirm("本当に削除しますか？（捨てる場合は、「捨てる」ボタンを押してください）")'>削除</button>
                </a>

        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
