<?php
/**
 * Import Shell.
 *
 * PHP Version 5
 *
 * @category Console
 * @package  Tuto.Blog.Console
 * @author   Nicolas Ramy-Sepou <nicolas.ramy@darkelda.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://darkelda.net
 */

class ImportShell extends Shell
{
	// Declare class used
    public $uses = array('Blog.Post');

    const LINE_LENGTH = 1024;
    const MY_DOWNLOADED_FILE = 'app/webroot/files/my_blog_post.csv';

    /**
     * Main
     *
     * @return void
     **/
	public function main()
	{
		return false;
	}

	/**
	 * my_blog_post
	 *
	 * @access public
	 * @return void
	 */
	public function my_blog_post()
	{
		if (($handle = @fopen(self::MY_DOWNLOADED_FILE, 'r')) !== false) {
            while (($row = fgetcsv($handle, self::LINE_LENGTH, ',')) !== false) {
                /**
                 * 0 id
                 * 1 title
                 * 2 content
                 */
                $data[] = $row;
            }
            fclose($handle);
        } else {
            $this->out('Unable to open this file');
            return false;
        }

        $total = count($data);
        $index = 0;
        $this->out('Rows: ' . $total);

		if (!$total) {
            $this->out('File seems to be empty');
            return false;
        }

        foreach ($data as $row) {
			$post = $this->getPost($row);
            if ($this->Post->insert($post)) {
				$this->out('Post added : ' . $post['Post']['id'] . ' ' . $post['Post']['title']);
			} else {
				$this->out('Can not add this post article');
			}

            $this->out('Progress: ' . number_format((($index / $total) * 100), 2) . '%');
            $index++;
        }

        $this->out('Done');
	}

	/**
	 * Transform Csv format to Post Model
	 *
	 * @access protected
	 * @return array
	 */
	protected function getPost($row = array())
	{
		if (empty($row) && count($row) == 3) {
			return false;
		}
		return array(
			'Post' => array(
				'id'		=> $row[0],
				'title'		=> $row[1],
				'content' 	=> $row[2]
			)
		);
	}
}
