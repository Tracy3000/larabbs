<?php
namespace App\Observers;
use App\Models\Link;
use Cache;
class LinkObserver {
    //保存时晴空对应cache_key缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}

?>