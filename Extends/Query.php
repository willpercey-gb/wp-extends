<?php


namespace UWebPro\WordPress;

/**
 * Class Query
 * @package UWebPro\WordPress
 *
 * @property $author
 * @property string $author_name
 * @property array $author__in
 * @property array $author__not_in
 *
 * @property int $cat
 * @property string $category_name
 * @property array $category__and
 * @property array $category__in
 * @property array $category__not_in
 *
 * @property string $tag
 * @property int $tag_id
 * @property array $tag__and
 * @property array $tag__in
 * @property array $tag__not_in
 * @property array $tag_slug__and
 * @property array $tag_slug__in
 *
 * @property array $tax_query
 *
 * @property int $p
 * @property string $name
 * @property int $page_id
 * @property string $pagename
 * @property int $post_parent
 * @property array $post_parent__in
 * @property array $post_parent__not_in
 * @property array $post__in
 * @property array $post__not_in
 * @property array $post_name__in
 *
 * @property bool $has_password
 * @property string $post_password
 *
 * @property string|array $post_type
 *
 * @property string $post_status
 *
 * @property int $posts_per_page
 * @property int $offset
 * @property int $posts_per_archive_page
 * @property int $paged
 * @property bool $ignore_sticky_posts
 *
 * @property string|array $order
 * @property string|array $orderby
 *
 * @property array $meta_query
 * @property string $meta_key
 * @property mixed $meta_value
 * @property int $meta_value_num
 * @property string $meta_compare
 *
 * @property int $year
 * @property int $monthnum
 * @property int $w
 * @property int $day
 * @property int $hour
 * @property int $minute
 * @property int $second
 * @property int $m
 * @property array $date_query
 *
 * @property string $perm
 *
 * @property string|array $post_mime_type
 *
 * @property bool $cache_results
 * @property bool $update_post_meta_cache
 * @property bool $update_post_term_cache
 *
 * @property string $fields
 *
 */

class Query
{
    private $data;

    private $query = [];

    public function __construct($type = 'post')
    {
        $this->orderBy();
        $this->paginate();
        $this->post_type = $type;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public static function __callStatic($name, $arguments)
    {
       return call_user_func_array(\WP_Query::class, $arguments);
    }

    public function filter($categories, $field = 'slug', $relation = 'AND', $taxonomy = 'category'): Query
    {
        if (!isset($this->query['tax_query'])) {
            $this->query['tax_query'] = [
                'relation' => $relation,
            ];
        }
        $this->query['tax_query'][] = [
            'taxonomy' => $taxonomy,
            'field' => $field,
            'terms' => (array)$categories,
        ];

        return $this;
    }

    public function orderBy(?string $taxonomy = null, string $direction = 'desc'): Query
    {
        $this->orderby = $taxonomy;
        $this->order = $direction;

        return $this;
    }

    public function paginate($limit = -1): Query
    {
        $this->posts_per_page = $limit;

        return $this;
    }

    public function page($pageNo)
    {
        $this->paged = $pageNo;
    }

    public function get(array $args = []): \WP_Query
    {
        $query = array_merge($this->data, $this->query, $args);

        return new \WP_Query($query);
    }
}