<?php
/**
 * Transaction Model
 *
 * PHP Version 5
 *
 * @category Model
 * @package  app.Plugin.Blog.Model
 * @author   Nicolas Ramy-Sepou <nicolas.ramy-sepou@joliebox.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://darkelda.net
 */

class Post extends BlogAppModel
{

    public function insert($post = array())
    {
        if (empty($post)) {
            return false;
        }

        $this->create();
        $this->data = array(
            'Post' => array(
                'id'        => $post['Post']['id'],
                'title'     => $post['Post']['title'],
                'content'   => $post['Post']['content'],
                'created'   => date('Y-m-d H:i:s'),
                'modified'   => null
            )
        );
        return $this->save();
    }
}
