<?php

/**
 * CodeSharp
 *
 * A CMS based on CodeIgniter
 *
 * @package		CodeSharp
 * @author		Andy Walpole (unless stated to the contrary)
 * @copyright	Andy Walpole (unless stated to the contrary)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/TCotton/CodeSharp
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Image_Model Class
 *
 * @package		CodeSharp
 * @subpackage	Application
 * @category	Models
 * @author		Andy Walpole
 * 
 */

class Image_Model extends CI_Model {

    var $gallery_path;
    var $thumb_path;

    public function __construct() {

        parent::__construct();

        // set values for the two attributes and make sure that the file permissions are set to 777

        $this->gallery_path = realpath(APPPATH . '../images/uploads');
        $this->thumb_path = realpath(APPPATH . '../images/thumbnail');

        chmod($this->gallery_path, 0777);
        chmod($this->thumb_path, 0777);

    }

    // --------------------------------------------------------------------

    /**
     * check_image_duplicate function
     *  checks image duplicate for the upload_image function below
     * Checks to see if upload image already exists
     * @access	private
     * @return	array
     */

    private function check_image_duplicate() {

        $sql = "SELECT filename FROM images";

        $query = $this->db->query($sql);

        return $query->result();

    }

    // --------------------------------------------------------------------

    /**
     * upload_file_database function
     * // create file row for new image
     * @access	private
     * @return	array
     */

    private function upload_file_database($file_type = "", $filename = "") {

        // date('Y-m-d H:i:s') = MySQL now() function

        $data = array('date' => date('Y-m-d H:i:s'), 'type' => $file_type, 'filename' =>
            $filename);

        return $this->db->insert('images', $data);

    }

    // --------------------------------------------------------------------

    /**
     * upload_image function
     * // function for validating image
     * @access	public
     * @return	array
     */

    public function upload_image() {

        $config = array();
        /**
         * Make sure file is an image, path upload is set and the image is not more than the maz size of 1mb
         */
        $config = array('allowed_types' => 'jpg|jpeg|png|gif', 'upload_path' => $this->
            gallery_path, 'max_size' => 1000, 'remove_spaces' => true);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("file_upload")) {

            $error = array('error' => $this->upload->display_errors());

            foreach ($error as $report) {

                return $report;

            } // end foreach

        } // end upload

    }
    
        // --------------------------------------------------------------------

    /**
     * resize_image function
     * // function to resize image
     * @access	private
     * @return	string
     */


    private function resize_image($image = "") {

        /**
         * Uses GD Imagine image library to resize images
         * Need to make sure that uploaded image is bigger than 250px before changing image size
         * 
         */


        if (class_exists('Imagine\Gd\Imagine')) {


            try {
                $imagine = new Imagine\Gd\Imagine();

                $imagine->open('images/uploads/' . $image)->thumbnail(new Imagine\Image\Box(250,
                    250))->save('images/thumbnail/' . $image);
            }
            catch (Imagine\exception \exception $e) {
                // handle the exception

                print "No Imagine image manipulation class exists";

            }

        }

    }


    // delete image details from image table row
    private function delete_image($image_id) {

        // destroy image in user-images folder
        if (file_exists($this->gallery_path . $imaqe_id)) {

            unlink($this->gallery_path . $imaqe_id);

        }

        // Destroy the thumbnail image
        if (file_exists("image-thumbnail/" . $imaqe_id)) {

            unlink($this->thumb_path . $imaqe_id);

        }

        $this->db->limit(1);

        $this->db->where('filename', $image_id);

        return $this->db->delete('user');


    }


    // function for updating image database
    // It is important that image name is unique

    public function update_image($image_id = "") {

        $duplicate = null;

        $data = array('upload_data' => $this->upload->data());

        $target_file = $data['upload_data']['orig_name'];

        // Check to see if target file is already named in the database
        // if so add random number at beginning in order to create unique title
        foreach ($this->check_image_duplicate() as $row) {

            if ($row->filename == $target_file) {

                //give filename a new name if already a duplicate
                $target_file = rand() . $target_file;

                $duplicate = 1;

                break;

            }
        }

        if ($duplicate !== null) {

            $this->upload_file_database($data['upload_data']['file_type'], $target_file);

            // rename uploaded file

            rename($this->gallery_path . "/" . $data['upload_data']['orig_name'], $this->
                gallery_path . "/" . $target_file);

            // resize image

            $this->resize_image($target_file);

            return $target_file;

        } else {

            $this->upload_file_database($data['upload_data']['file_type'], $target_file);

            // resize image

            $this->resize_image($target_file);

            return $target_file;

        }


        // if image comes from edit content form then make sure previous image is deleted from the database and
        // from the images folder

        if ($image_id !== "") {

            $this->delete_image($image_id);

        }

    }

} // end of class
