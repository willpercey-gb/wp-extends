# WordPress Extends
Allowing you to use WordPress your way

## WP_Post
```php
<?php
use UWebPro\WordPress\Post as WP_Post;

class CareHomes extends WP_Post{
    public function location(): ?string
    {
        $category = \wp_get_post_terms($this->ID, 'locations');
        return !$category ? null : $category[0]->name;
    }
}
```
