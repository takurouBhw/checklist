
<?php
namespace Lib\Util;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


function create_check_items_json($id, $max)
{
    $max_row = $max;
    $now = new Carbon();
    $check_items = [];

    for ($i = 1; $i <= $max_row; $i++) {
        $item = [
            "title" => 'テスト' . $i,
            "headline" => random_int(0, 1),
            "input" => random_int(0, 1),
            "edited_at" => $now->format('Y-m-d H:i:s'),
        ];
        $check_items["{$i}"] = $item;
    }

    // $json_file_path = "public/works/{$id}_checkitem.dat";
    $json_file_path = "public/works/{$id}_checkitem.dat";
    Storage::put($json_file_path, json_encode($check_items, true));
}
