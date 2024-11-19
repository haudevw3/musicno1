<?php

namespace Modules\Categories\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Modules\Categories\Constant;

class Category extends Model
{
    /**
     * Assign different a connection if any.
     *
     * @var string
     */
    protected $connection = 'musicno1';

    /**
     * The collection name in Mongo DB.
     *
     * @var string
     */
    protected $collection = 'categories';

    /**
     * The attribute will disabled.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Assign fields to save in the database.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '_id',
        'id',
        'parent_id',
        'priority',
        'name',
        'slug',
        'images',
        'tag_type',
        'tag_ids',
        'created_at',
        'updated_at',
    ];

    /**
     * Define default values for the model's attributes.
     *
     * @var array<string|int, string|null>
     */
    protected $attributes = [
        'id' => '',
        'parent_id' => '',
        'priority' => 0,
        'name' => '',
        'slug' => '',
        'images' => [],
        'tag_type' => 0,
        'tag_ids' => [],
        'created_at' => '',
        'updated_at' => '',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Determine if the primary category.
     *
     * @return bool
     */
    public function isPrimary()
    {
        return $this->tag_type === Constant::TAG_PRIMARY;
    }

    /**
     *  Determine if it's not the primary category.
     *
     * @return bool
     */
    public function isNotPrimary()
    {
        return ! $this->isPrimary();
    }

    /**
     * Get the badge following the property "tag_type".
     *
     * @param  int|null  $key
     * @param  string    $value
     * @return string
     */
    public function badge($key = null, $value = null)
    {
        $key = ! is_null($key) ? $key : $this->tag_type;

        if ($key == 0) {
            $badgeKey = 'blue';
        } elseif ($key == 1) {
            $badgeKey = 'pink';
        } elseif ($key == 2) {
            $badgeKey = 'indigo';
        } else {
            $badgeKey = 'green';
        }

        return badge(
            $badgeKey, $value ?? config('categories.tag_types')[$key]
        );
    }
}
