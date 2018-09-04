<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Fetchaa;
use App\Models\ArtistFav;
use App\Traits\MyStorage;
use App\Traits\FetchaaData;
use App\Http\Requests\StoreFetchaaRequest;
use DB;

class FetchaaController extends Controller
{
    use MyStorage, FetchaaData;

    private $importDir;
    private $storedDir;

    public function __construct()
    {
        $this->importDir = config('cfg.fetchaa.importDir');
        $this->storedDir = config('cfg.fetchaa.storedDir');
        $this->middleware('FormInputRemoveEol:title,artist,av_icode')->only(['update']);
        $this->middleware('FormInputSingleSpace:title,artist,av_icode')->only(['update']);
    }

    /**
     * 顯示首頁
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validQuery = [];
        $threadTypes = config('cfg.fetchaa.threadTypes');
        $type = $request->query('type', '');
        $query = Fetchaa::query();
        $threadTitle = '所有文章';

        if (!empty($type) && array_key_exists($type, $threadTypes))
        {
            $query->where('thread_type', $type);
            $threadTitle = $threadTypes[$type]['label'];
            $validQuery['type'] = $type;
        }

        $threads = $query->orderBy('id', 'asc')->paginate(50);

        if (!empty($validQuery))
        {
            $threads->appends($validQuery);
        }

        return view('fetchaa.index', compact('threads', 'threadTitle'));
    }

    /**
     * 顯示沒有 (av_icode|artist|both) 的所有文章
     *
     * @param  string $field (av_icode|artist|both)
     * @return \Illuminate\Http\Response
     */
    public function empty($field)
    {
        $query = Fetchaa::whereNotIn('thread_type', ['western','uncensored','heydouga']);
        $threadTitle = [];

        if ($field == 'av_icode' || $field == 'both')
        {
            $query->where('av_icode', '');
            $threadTitle[] = 'AV-Icode';
        }

        if ($field == 'artist' || $field == 'both')
        {
            $query->where('artist', '');
            $threadTitle[] = 'Artist';
        }

        $threadTitle = '沒有 ' . implode(', ', $threadTitle) . ' 的文章';
        $threads = $query->where('title', 'NOT LIKE', 'S-Cute%')
                         ->where('title', 'NOT LIKE', 'Mywife%')
                         ->orderBy('id', 'asc')
                         ->paginate(50);

        return view('fetchaa.index', compact('threads', 'threadTitle'));
    }

    /**
     * 顯示所有重複 AV-Icode 的文章
     *
     * @return \Illuminate\Http\Response
     */
    public function dupeAvIcode()
    {
        $threadTitle = '所有重複 AV-Icode 的文章';
        // 現在改用一個更快的 query 語法
        // search Evernote use keyword："Mysql 5.7 default "ONLY_FULL_GROUP_BY" SQL mode is enabled"
        $threads = Fetchaa::whereIn('id', function($query)
                    {
                        $query->selectRaw('MIN(id) id')
                              ->from('fetchaa')
                              ->whereNotIn('thread_type', ['western','uncensored','heydouga'])
                              ->where('av_icode', '<>', '')
                              ->groupBy('av_icode')
                              ->havingRaw('COUNT(av_icode) > 1');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(50); // 將 ->paginate(50); 改為 ->toSql(); 可輸出語法

        return view('fetchaa.index', compact('threads', 'threadTitle'));
    }

    /**
     * 顯示所有關注的文章
     *
     * @return \Illuminate\Http\Response
     */
    public function isFocus()
    {
        $threadTitle = '關注的文章';
        $threads = Fetchaa::where('is_focus', 1)->orderBy('id', 'asc')->paginate(50);

        return view('fetchaa.index', compact('threads', 'threadTitle'));
    }

    /**
     * 顯示編輯文章的表格
     *
     * @param  \App\Models\Fetchaa  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Fetchaa $thread)
    {
        $dupeAvIcodeThreadsCount = empty($thread->av_icode) ? 0 : Fetchaa::getThreadsByAvIcode($thread->av_icode)->count();
        // 取得此 thread 的所有 fetchaa_images
        $threadImages = collect(Storage::disk('fetchaa_images')->files($thread->fetch_date . '/' . $thread->tid))
                            ->map(function($file) {
                                return Storage::disk('fetchaa_images')->url($file);
                            });

        if (! $thread->is_read)
        {
            Fetchaa::updateIsReadByIds([$thread->id]);
        }

        return view('fetchaa.edit', compact('thread', 'dupeAvIcodeThreadsCount', 'threadImages'));
    }

    /**
     * 顯示所有 thread_type 而又未檢查的 thread
     *
     * @return \Illuminate\Http\Response
     */
    public function unread()
    {
        $unreadTotalCount = 0;
        $unreads = Fetchaa::where('is_read', 0)->orderBy('av_icode', 'asc')->orderBy('id', 'asc')->get()->toArray();
        $unreadTypes = config('cfg.fetchaa.threadTypes');

        foreach ($unreadTypes as $threadType => $threadTypeVal)
        {
            $unreadTypes[$threadType]['datas'] = array_filter($unreads, function($val) use ($threadType) {
                                                    return $val['thread_type'] == $threadType;
                                                 });

            $count = count($unreadTypes[$threadType]['datas']);
            $unreadTypes[$threadType]['count'] = $count;
            $unreadTotalCount += $count;
        }

        return view('fetchaa.unread', ['unreadTypes' => $unreadTypes, 'unreadTotalCount' => $unreadTotalCount]);
    }

    /**
     * 顯示有多少筆 txt 檔案可以匯入至資料庫
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $this->importCheck();
        $matchDirs = $this->myStorageFindDirs('fetchaa', $this->importDir, '(\d{4}-\d{2}-\d{2})');
        $matchFiles = $this->myStorageFindFiles('fetchaa', $matchDirs, '(\d{7})\.txt');
        $fetchaaImportTxtCount = count($matchFiles);
        return view('fetchaa.import', compact('fetchaaImportTxtCount'));
    }

    /**
     * 匯入資料至資料庫, 完成後移動 txt 檔案
     *
     * @return \Illuminate\Http\Response
     */
    public function storeImport()
    {
        $startTime = \Carbon\Carbon::now(); // 標記開始執行時間, 用來計算程序花了多少時間
        $importErrors = [];

        // 檢查必須的目錄和檔案
        $this->importCheck();

        if ( Storage::disk('fetchaa')->get(config('cfg.fetchaa.fetchActionLock')) !== '0' )
        {
            return back()->withErrors(['error' => '系統正在找取資料中，請稍後再匯入資料。']);
        }

        // 取得所有符合日期樣式的目錄
        $dirs = $this->myStorageFindDirs('fetchaa', $this->importDir, '(\d{4}-\d{2}-\d{2})');
        $txts = [];
        $dbLastTid = Fetchaa::getLastTid(); // 匯入的資料必須大於此 $dbLastTid

        foreach ($dirs as $dir)
        {
            $files = Storage::disk('fetchaa')->files($dir['dirPath']);

            foreach ($files as $file)
            {
                if ( preg_match('/^' . path_to_pattern($dir['dirPath']) . '\/(\d{7})\.txt$/u', $file, $matches) )
                {
                    // 現在的 $matches[1] = tid 必須大於舊記錄
                    if ($matches[1] > $dbLastTid)
                    {
                        $txts[] = [
                            'importPath' => $file,
                            'storedPath' => str_replace_first($this->importDir, $this->storedDir, $file),
                            'fetch_date' => $dir['dirValue'],
                            'tid' => $matches[1]
                        ];
                    }
                }
            }
        }

        $txtsCount = count($txts);
        $dbSavedCount = 0;

        if (! $txtsCount)
        {
            return back()->withErrors(['error' => '沒有任何符合規格的 txt 檔案可以匯入。']);
        }

        // 將我的最愛藝人存成陣列, 用 desc 是因為用最近期的 artist 來比對一路匯入的新資料
        // 這樣在開始比對時命中比較高
        $favArtists = ArtistFav::orderBy('id', 'desc')->pluck('artist_name')->toArray();
        $constants = $this->fetchaaConstants(); // From Trait 取得不變的常數

        foreach ($txts as $txt)
        {
            $htmlCode = Storage::disk('fetchaa')->get($txt['importPath']);
            $htmlCode = strip_tags($htmlCode, '<a><span>'); // 保留 <a><span> tag
            $htmlCodes = explode("\r\n", $htmlCode);

            // loop 每一行, 如果包含 ignoreHtmlCode 的字串, 將該行轉為空白 ''
            $htmlCodes = array_map(function($line) use ($constants) {
                            return str_contains($line, $constants['ignoreHtmlCode']) ? '' : $line;
                         }, $htmlCodes);

            //
            // ----- 初始化預設值 -----
            // 初始化所有 thread_type 的 flag 為 false, 之後如果符合條件就修改 false 值
            // 然後在最後用 array_filter() 只保留非 false 的元素
            // other 放在最後, 是不會被 array_filter() 移除
            // 用 reset() 取得第一個元素, 元素值就是 thread_type
            // 所以 $threadTypes 陣列裡的元素是根據優先順序而排列
            //
            $threadTypes = config('cfg.fetchaa.threadTypes');
            $regdate = '';
            $title = '';
            $artists = [];
            $avIcodes = [];
            $urls = [];
            $clearCode = '';

            if (count($htmlCodes))
            {
                // 產生 clearCode
                $clearCode = implode("\r\n", $htmlCodes);
                $clearCode = strip_tags($clearCode); // 移除所有 html tag
                $clearCodes = string_to_array_filter($clearCode);
                $clearCode = implode("\r\n", $clearCodes); // 轉為 string, 現在已經可以直接儲存至資料庫, 無需再作處理
            }

            // 找取其他資料前, $htmlCodes 要先進行簡單處理
            $htmlCodes = array_map(function($line) {
                            return trim(single_space($line));
                         }, $htmlCodes);
            $htmlCodes = array_filter($htmlCodes);

            // 讀取每一行原始碼
            foreach ($htmlCodes as $line)
            {
                // 產生 urls, 每一行都會執行
                if (preg_match($constants['urlsPattern'], $line, $matches))
                {
                    $urls[] = [
                        'url' => urldecode($matches[1]),
                        'name' => $matches[2]
                    ];
                    continue;
                }

                // 產生 regdate, 找到第一次後不會再執行
                if ( $regdate == '' && preg_match($constants['regdatePattern'], $line, $matches) )
                {
                    $regdate = $matches[1];
                    continue;
                }

                // 產生 title, 找到第一次後不會再執行, 因為 title 也會包含 artist, 所以不能用 continue;
                if ( $title == '' && preg_match($constants['titlePattern'], $line, $matches) )
                {
                    $title = $this->fetchaaFormatTitle($matches[1]);
                    // 決定 thread_type, 如果符合將會改變 $threadTypes 元素的 false 值
                    $threadTypes = $this->fetchaaThreadTypeByTitle($title, $matches[2], $threadTypes);

                    // 如果 title 符合以下條(不分大小寫), 將 $newIcode 加入 $avIcodes 陣列, 及修改 title
                    if (preg_match('/^([a-z]+)-?(\d+)\s/i', $title, $matches))
                    {
                        if (! $this->fetchaaIsFakeAvIcode(trim($matches[0])) )
                        {
                            $newIcode = strtoupper($matches[1] . '-' . $matches[2]);
                            $title = str_replace_first(trim($matches[0]), $newIcode, $title);
                            $avIcodes[] = $newIcode;
                        }
                    }
                }

                // 決定 thread_type, 全文搜索, 找到第一次後不會再執行
                $threadTypes = $this->fetchaaThreadTypeByOthers($line, $favArtists, $threadTypes);

                // 全文搜索 artist, 如果符合便加進陣列
                if (preg_match('/^(' . $constants['artistPattern'] . ')(:|：)?(.*)$/u', $line, $matches))
                {
                    $artists[] = end($matches);
                }

                // 全文搜索 av_icode, 如果符合便加進陣列
                if (preg_match('/^(' . $constants['avIcodePattern'] . ')(:|：)?(.*)$/u', $line, $matches))
                {
                    $avIcodes[] = end($matches);
                }
            } // end foreach $htmlCodes (讀取每一行原始碼)

            //
            // *** 來到這裡, 已經取得一個 txt 所有必須的資料, 在寫入 database 之前, 某些資料要先進行運算 ***
            //

            // 判斷原始碼的真確性, 如果沒有 title 根本無需再判斷 clearCode
            if (empty($regdate) || empty($title))
            {
                return back()->withErrors(['error' => '匯入的資料日期：' . $txt['fetch_date'] . ' tid：' . $txt['tid'] . ' 沒有 regdate 或 title']);
            }

            $threadTypes = array_filter($threadTypes, function($val) {
                                return $val['flag'] !== false;
                           });
            $threadType = reset($threadTypes); // 取得第一個元素的值
            $threadType = $threadType['flag'];

            $artist = $this->fetchaaFormatArtist($artists);
            $avIcode = $this->fetchaaFormatAvIcode($avIcodes);

            $fetchaa = new Fetchaa;
            $fetchaa->fetch_date = $txt['fetch_date'];
            $fetchaa->is_read = '0';
            $fetchaa->is_focus = '0';
            $fetchaa->is_merge = '0';
            $fetchaa->thread_type = $threadType;
            $fetchaa->regdate = $regdate;
            $fetchaa->tid = $txt['tid'];
            $fetchaa->title = $title;
            $fetchaa->artist = $artist;
            $fetchaa->av_icode = $avIcode;
            $fetchaa->urls = $urls; // 儲存陣列至資料庫
            $fetchaa->clear_code = $clearCode;
            $fetchaa->save();

            //
            // *** 成功儲存一筆 txt 資料至 database 之後的動作 ***
            //
            $dbSavedCount++;
            // 移動 txt 檔案
            if (! $this->myStorageMoveFile('fetchaa', $txt['importPath'], $txt['storedPath']) )
            {
                $importErrors[] = sprintf('無法移動檔案 %s 至 %s，可能目標檔案已經存在。', $txt['importPath'], $txt['storedPath']);
            }
        } // end foreach $txts

        //
        // *** 所有寫入資料庫操作完成, 進行最後階段 ***
        //

        // 先刪除所有 split_line.bak , 一定要使用 $dirs 作參數, 因為匯入資料的根源都是依據 $dirs 得來的
        $bakFiles = $this->myStorageFindFiles('fetchaa', $dirs, '(.*)split_line.bak');

        foreach ($bakFiles as $bakFile)
        {
            if (! Storage::disk('fetchaa')->delete($bakFile['filePath']))
            {
                $importErrors[] = '無法刪除檔案 ' . $bakFile['filePath'];
            }
        }

        // 再刪除空的 'fetch_date' yyyy-mm-dd 資料夾
        $delDirs = $this->myStorageFindDirs('fetchaa', $this->importDir, '(\d{4}-\d{2}-\d{2})');

        foreach ($delDirs as $delDir)
        {
            if (empty(Storage::disk('fetchaa')->allFiles($delDir['dirPath'])))
            {
                if (! Storage::disk('fetchaa')->deleteDirectory($delDir['dirPath']))
                {
                    $importErrors[] = '無法刪除空的目錄 ' . $delDir['dirPath'];
                }
            }
        }

        // 使用 session 輸出 $importResult
        $importResult['importTime'] = \Carbon\Carbon::now()->diff($startTime)->format('%H:%I:%S');
        $importResult['txtsCount'] = $txtsCount;
        $importResult['dbSavedCount'] = $dbSavedCount;
        $importResult['lastId'] = $fetchaa->id;
        $importResult['lastFetchDate'] = $fetchaa->fetch_date;
        $importResult['lastTid'] = $fetchaa->tid;

        // 千萬不要在 POST 儲存資料後使用 return view()
        // 因為在 browser 的 URL 仍然停留在之前的狀態 (POST) http://localhost/fetchaa/store-import
        // 按 F5 會不停地重複 submit 相同的資料
        return redirect()->route('fetchaa.import')->with($importResult)->withErrors($importErrors);
    }

    /**
     * 批次標記文章為已檢查
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markread(Request $request)
    {
        $this->validate($request, [
            'id.*' => 'required|integer|distinct'
        ]);

        Fetchaa::updateIsReadByIds($request->input('id'));
        return back();
    }

    /**
     * 合併重複 AV-Icode 的文章
     *
     * @param  \App\Models\Fetchaa  $thread
     * @return \Illuminate\Http\Response
     */
    public function merge(Fetchaa $thread)
    {
        $mergeErrors = [];

        if (empty($thread->av_icode))
        {
            abort(500, "fetchaa (id：" . $thread->id . ") 的 av_icode 為空字串，所以無法進行記錄合併。");
        }

        $dupeThreads = Fetchaa::getThreadsByAvIcode($thread->av_icode);

        if ($dupeThreads->count() < 2)
        {
            abort(500, "fetchaa (id：" . $thread->id . ") 的 av_icode 沒有重複，所以無法進行記錄合併。");
        }

        // 先用完整的 result set 計算出以下各項資料
        $artist = $this->fetchaaFormatArtist($dupeThreads->pluck('artist')->toArray());
        $is_focus = $dupeThreads->max('is_focus');
        $urls = $dupeThreads->pluck('urls')->collapse()->toArray();
        $title  = $dupeThreads->sortByDesc(function($field) {
                        return strlen($field['title']);
                  })->pluck('title')->first();

        // 必須先在完整的 result set 計算出上面各項資料後, 才可以將 result set 分割成第一筆資料和其他資料
        $masterThread = $dupeThreads->shift(); // 從 result set 抽出第一筆資料
        $destroyIds = $dupeThreads->pluck('id')->toArray();

        $masterThread->is_focus = $is_focus;
        $masterThread->is_merge = 1;
        $masterThread->title = $this->fetchaaFormatTitle($title);
        $masterThread->artist = $artist;
        $masterThread->urls = $urls;

        // Begin Transaction
        DB::beginTransaction();
        try
        {
            $masterThread->save();
            Fetchaa::whereIn('id', $destroyIds)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        // End Transaction

        // 等資料庫操作完成後才合併所有 images to masterThread
        $toFolder = $masterThread->fetch_date . '/' . $masterThread->tid;

        foreach ($dupeThreads as $dupeThread)
        {
            $fromFolder = $dupeThread->fetch_date . '/' . $dupeThread->tid;
            $fromImages = Storage::disk('fetchaa_images')->files($fromFolder);

            // 每一個檔案
            foreach ($fromImages as $fromImage)
            {
                $file = pathinfo($fromImage)['basename'];
                $fromFile = $fromFolder . '/' . $file;
                $toFile = $toFolder . '/' . $file;

                // 移動 image
                if (! $this->myStorageMoveFile('fetchaa_images', $fromFile, $toFile) )
                {
                    $mergeErrors[] = sprintf('無法移動檔案 %s 至 %s，可能目標檔案已經存在。', $fromFile, $toFile);
                }
            }

            // 移動所有檔案後, 刪除來源目錄
            if (! $this->myStorageDeleteDirIfExist('fetchaa_images', $fromFolder))
            {
                $mergeErrors[] = '無法刪除 Disk：fetchaa_images 已存在的目錄 ' . $fromFolder;
            }
        }

        return redirect()->route('fetchaa.edit', $masterThread->id)->withErrors($mergeErrors);
    }

    /**
     * 更新文章
     *
     * @param  StoreFetchaaRequest  $request
     * @param  \App\Models\Fetchaa  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFetchaaRequest $request, Fetchaa $thread)
    {
        $thread->title = $this->fetchaaFormatTitle($request->input('title'));
        $thread->artist = empty($request->input('artist')) ? '' : $this->fetchaaFormatArtist([$request->input('artist')]);
        $thread->av_icode = empty($request->input('av_icode')) ? '' : $this->fetchaaFormatAvIcode([$request->input('av_icode')]);
        $thread->is_focus = $request->input('is_focus');
        $thread->save();

        return back();
    }

    /**
     * 刪除文章
     *
     * @param  \App\Models\Fetchaa  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fetchaa $thread)
    {
        $imagesFolder = $thread->fetch_date . '/' . $thread->tid;
        $thread->delete();

        // 刪除 image 目錄
        if (! $this->myStorageDeleteDirIfExist('fetchaa_images', $imagesFolder))
        {
            abort(500, '無法刪除 Disk：fetchaa_images 已存在的目錄 ' . $imagesFolder);
        }

        return redirect()->route('fetchaa.index');
    }

    /**
     * 在匯入前, 先檢查必要的的目錄及檔案
     */
    private function importCheck()
    {
        if (! Storage::disk('fetchaa')->exists($this->importDir))
        {
            abort(500, "內部錯誤，找不到存放匯入資料的目錄 " . $this->importDir);
        }

        if (! Storage::disk('fetchaa')->exists($this->storedDir))
        {
            abort(500, "內部錯誤，找不到用來存放已經匯入資料的目錄 " . $this->storedDir);
        }

        if (! Storage::disk('fetchaa')->exists(config('cfg.fetchaa.fetchActionLock')))
        {
            abort(500, "內部錯誤，找不到檔案 " . config('cfg.fetchaa.fetchActionLock'));
        }
    }
}
