<?php

namespace Apolune\News;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Apolune\Core\Database\Eloquent\Model;
use Apolune\Contracts\News\Article as Contract;

class Article extends Model implements Contract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '__pandaac_news';
    
    /**
     * Retrieve the article ID.
     *
     * @return integer
     */
    public function id()
    {
        return $this->attributes['id'];
    }

    /**
     * Retrieve the article slug.
     *
     * @return string
     */
    public function slug()
    {
        return $this->attributes['slug'];
    }

    /**
     * Retrieve the article title.
     *
     * @return string
     */
    public function title()
    {
        return $this->attributes['title'];
    }

    /**
     * Retrieve the article content.
     *
     * @return string
     */
    public function content()
    {
        return $this->attributes['content'];
    }

    /**
     * Retrieve the article excerpt.
     *
     * @param  integer  $words  100
     * @param  string  $end  ...
     * @return string
     */
    public function excerpt($words = 100, $end = '...')
    {
        if (! $this->attributes['excerpt']) {
            return Str::words(strip_tags($this->content()), $words, $end);
        }

        return strip_tags($this->attributes['excerpt']);
    }

    /**
     * Retrieve the article type.
     *
     * @return string
     */
    public function type()
    {
        return $this->attributes['type'];
    }

    /**
     * Retrieve the article icon.
     *
     * @return string
     */
    public function icon()
    {
        return $this->attributes['icon'];
    }

    /**
     * Retrieve the article image.
     *
     * @return string
     */
    public function image()
    {
        return strpos($path = $this->attributes['image'], '/') === 0 ? asset($path) : $path;
    }

    /**
     * Retrieve the article creation date.
     *
     * @return \Carbon\Carbon
     */
    public function creation()
    {
        return new Carbon($this->attributes['created_at']);
    }
}
