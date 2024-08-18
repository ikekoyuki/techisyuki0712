<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * モノ一覧
     */
    public function index(Request $request)
    {
        // モノ一覧取得
        $query = Item::query();
        $name = $request->input('name');
        $area = $request->input('area');
        $type = $request->input('type');
        $purchasedate = $request->input('purchasedate');
        $detail = $request->input('detail');

        //捨てたものは表示しない
        $query->where('type', '!=', 3);

                //　名前で検索
                if(!empty($name)) {
                    $query->where('name', 'LIKE', "%{$name}%");
                }

                //　エリアで検索 （0の場合はemptyだと空とみなすためissetを使用)
                if(isset($area)) {
                    $query->where('area', '=', $area);
                }

                //　分類で検索 （0の場合はemptyだと空とみなすためissetを使用)
                if(isset($type)) {
                    $query->where('type', '=', $type);
                }

                // ユーザーのモノのみ表示
                $query -> where('user_id',Auth::user()->id)->get();

                // 更新日時の降順で並び替え
                $query->orderBy('updated_at', 'desc');

                //ページネーション
                $items = $query->paginate(15);

        return view('item.index', compact('items','name','area','type','purchasedate','detail'));

    }

    /**
     * モノ登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:50',
                'area' => 'required',
                'type' => 'required',
                'detail' => 'max:300',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'name.required' => '名前を入力してください',
                'name.max' => '名前の入力は50文字までです。',
                'area.required' => 'エリアを選択してください',
                'type.required' => '分類を選択してください',
                'detail.max' => 'メモの入力は300文字までです。',
                'image.required' => '画像をアップロードしてください。',
                'image.image' => '有効な画像ファイルを選択してください。',
                'image.mimes' => 'アップロードできる画像形式はjpeg, png, jpg, gifのみです。',
                'image.max' => '画像のサイズは2MB以下にしてください。',
            ]);

            // モノ登録

            // 画像をBase64エンコードして保存
            $image = base64_encode(file_get_contents($request->file('image')->getRealPath()));


            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'area' => $request->area,
                'type' => $request->type,
                'purchasedate' => $request->purchasedate,
                'detail' => $request->detail,
                'image' => $image
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    /**
     * モノ編集
     */
    public function edit(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:50',
                'area' => 'required',
                'type' => 'required',
                'detail' => 'max:300',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ],
            [
                'name.required' => '名前を入力してください',
                'name.max' => '名前の入力は50文字までです。',
                'area.required' => 'エリアを選択してください',
                'type.required' => '分類を選択してください',
                'detail.max' => 'メモの入力は300文字までです。',
                'image.image' => '有効な画像ファイルを選択してください。',
                'image.mimes' => 'アップロードできる画像形式はjpeg, png, jpg, gifのみです。',
                'image.max' => '画像のサイズは2MB以下にしてください。'
            ]);

        $item = Item::find($request->id);

        if ($item) {
            // 画像がアップロードされた場合
            if ($request->hasFile('image')) {
                // 画像を保存しパスを取得
                $imagePath = $request->file('image')->store('images', 'public'); // publicに保存
                $image = base64_encode(file_get_contents(storage_path('app/public/' . $imagePath)));
                $item->image = $image; // データベースにBase64エンコードされた画像を保存
            }

            // 他のフィールドを更新
            $item->update([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'area' => $request->area,
                'type' => $request->type,
                'purchasedate' => $request->purchasedate,
                'dumpdate' => $request->dumpdate,
                'detail' => $request->detail,
            ]);

            // リダイレクト処理
            if ($item->type != 3) {
                return redirect('/items');
            }

            return redirect('/items/lookback');
        }
    }

    // 編集ページを表示
    $item = Item::find($request->id);
    $image = $item->image;  // 既存の画像を取得してビューに渡す
    return view('item.edit', ['item' => $item, 'image' => $image]);
}

    /**
     * 捨てる
     *
     * @param Request $request
     * @return Response
     */
    public function dump(Request $request)
    {
        $items = Item::where('id', $request->id)->first();
        $items->type = 3;
        $items->dumpdate = now();
        $items->save();

        return redirect('/items');

    }

    /**
     * 削除
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $items = Item::where('id', $request->id)->first();

        if ($items->type != 3) {

        $items->delete();
        return redirect('/items');

        }

        $items->delete();
        return redirect('/items/lookback');

    }

    /**
     * 捨てたモノ振り返り一覧
     */
    public function lookback(Request $request)
    {
        // 捨てたモノ振り返り一覧取得
        $query = Item::query();
        $name = $request->input('name');
        $area = $request->input('area');
        $type = $request->input('type');
        $detail = $request->input('detail');

        //捨てたものだけ表示
        $query->where('type', '=', 3);

                //名前で検索
                if(!empty($name)) {
                    $query->where('name', 'LIKE', "%{$name}%");
                }

                //エリアで検索 （0の場合はemptyだと空とみなすためissetを使用)
                if(isset($area)) {
                    $query->where('area', '=', $area);
                }

                // ユーザーのモノのみ表示
                $query -> where('user_id',Auth::user()->id)->get();

                // 捨てた日の降順で並び替え
                $query->orderBy('dumpdate', 'desc');

                //ページネーション
                $items = $query->paginate(15);

        return view('item.lookback', compact('items','name','area','type','detail'));

    }

    /**
     * 元に戻す
     *
     * @param Request $request
     * @return Response
     */
    public function undo(Request $request)
    {
        $items = Item::where('id', $request->id)->first();
        $items->type = 2;
        $items->save();

        return redirect('/items/lookback');

    }

}
