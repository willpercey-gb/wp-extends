<?php


namespace UWebPro\WordPress;

/**
 * Class Post
 * @package UWebPro\WordPress
 *
 * @property int $ID
 * @property string $post_author
 * @property string $post_date
 * @property string $post_date_gmt
 * @property string $post_content
 * @property string $post_title
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_name
 * @property string $to_ping
 * @property string $pinged
 * @property string $post_modified
 * @property string $post_modified_gmt
 * @property int $post_content_filtered
 * @property string $post_parent
 * @property int $guid
 * @property string $menu_order
 * @property string $post_type
 * @property string $post_mime_type
 * @property $comment_count
 * @property string $filter
 *
 * @property string $page_template
 *
 * @property-read array $ancestors
 * @property-read int $post_category
 * @property-read string $tag_input
 *
 * @method static \WP_Post get_instance(int $post_id)
 * @method array|boolean|object|\WP_Post filter(string $filter)
 * @method array to_array()
 */
class Post
{
    /**
     * @var Post
     */
    private static $instance;

    /**
     * @var \WP_Post
     */
    private $the_post;

    public function __construct(?\WP_Post $post = null)
    {
        if (!$post) {
            $this->_use();
        } else {
            $this->the_post = $post;
        }
    }

    private function _use(): void
    {
        global $post;
        if (!$this->the_post) {
            $this->the_post = $post;
        }
    }

    private static function instance(): WP_Post_Extension
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = (new self());
        return self::$instance;
    }

    public function __isset($name)
    {
        $this->_use();
        return isset($the_post->$name);
    }

    public function __set($name, $value)
    {
        $this->_use();
        $this->the_post->$name = $value;
    }

    public function __get($name)
    {
        $this->_use();
        return $this->the_post->$name;
    }

    public function __call($name, $arguments)
    {
        $this->_use();
        return call_user_func_array([$this->the_post, $name], $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        self::instance()->_use();
        return call_user_func_array([\WP_Post::class, $name], $arguments);
    }
}