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
        $detail = $request->input('detail');

        //捨てたものは表示しない
        $query->where('type', '!=', 3);

                //名前で検索
                if(!empty($name)) {
                    $query->where('name', 'LIKE', "%{$name}%");
                }

                //エリアで検索 （0の場合はemptyだと空とみなすためissetを使用)
                if(isset($area)) {
                    $query->where('area', '=', $area);
                }

                //分類で検索 （0の場合はemptyだと空とみなすためissetを使用)
                if(isset($type)) {
                    $query->where('type', '=', $type);
                }

                // 登録日時の昇順で並び替え
                $query->orderBy('created_at', 'asc');

                //ページネーション
                $items = $query->paginate(15);

        return view('item.index', compact('items','name','area','type','detail'));

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
                'name' => 'required|max:100',
            ]);

            // モノ登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'area' => $request->area,
                'type' => $request->type,
                'detail' => $request->detail
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
                'name' => 'required|max:100',
            ]);

        $items = Item::find($request->id);

        if ($items) {
            $items->update([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'area' => $request->area,
                'type' => $request->type,
                'detail' => $request->detail
            ]);
        }

        return redirect('/items');
        }

        return view('item.edit',['item' => Item::find($request->id)] );
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
        $items->delete();

        return redirect()->back();
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

                // 登録日時の昇順で並び替え
                $query->orderBy('created_at', 'asc');

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
