<?php

namespace Apolune\Contracts\News;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

interface Ticker extends ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    /**
     * Retrieve the ticker ID.
     *
     * @return integer
     */
    public function id();

    /**
     * Retrieve the ticker slug.
     *
     * @return string
     */
    public function slug();

    /**
     * Retrieve the ticker content.
     *
     * @return string
     */
    public function content();

    /**
     * Retrieve the ticker excerpt.
     *
     * @param  integer  $limit  300
     * @param  string  $end  ...
     * @return string
     */
    public function excerpt($limit = 300, $end = '...');

    /**
     * Retrieve the ticker type.
     *
     * @return string
     */
    public function type();

    /**
     * Retrieve the ticker icon.
     *
     * @return string
     */
    public function icon();

    /**
     * Retrieve the ticker creation date.
     *
     * @return \Carbon\Carbon
     */
    public function creation();
}
