<?php

/**
 * @author Andy Walpole
 * @date 7/11/2011
 * 
 */

$config = array(
                 'addnode' => array(
                                    array(
                                            'field' => 'title',
                                            'label' => 'Title',
                                            'rules' => 'trim|required|max_length[100]'
                                         ),
                                    array(
                                            'field' => 'select',
                                            'label' => 'Category',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'body',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'publish',
                                            'label' => 'Publish article',
                                            'rules' => 'required'
                                         )
                                    ),
                                    
                 'editnode' => array(
                                    array(
                                            'field' => 'title',
                                            'label' => 'Title',
                                            'rules' => 'trim|required|max_length[100]'
                                         ),
                                    array(
                                            'field' => 'body',
                                            'label' => 'Content',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'date',
                                            'label' => 'date',
                                            'rules' => 'trim|required|callback_isValidDateTime'
                                         )
                                    ),
                                    
                 'addcategory' => array(
                                    array(
                                            'field' => 'nameAdd',
                                            'label' => 'Name',
                                            'rules' => 'trim|required|max_length[40]|callback_check_duplicates'
                                         ),
                                    array(
                                            'field' => 'publishAdd',
                                            'label' => 'Publish',
                                            'rules' => 'required'
                                         )
                                    ),
                                    
                  'adminconfig' => array(
                                    array(
                                            'field' => 'nameForm',
                                            'label' => 'website title',
                                            'rules' => 'trim|required|max_length[100]'
                                         ),
                                    array(
                                            'field' => 'sloganForm',
                                            'label' => 'slogan',
                                            'rules' => 'trim|required|max_length[250]'
                                         ),
                                    array(
                                            'field' => 'emailForm',
                                            'label' => 'email',
                                            'rules' => 'trim|required|max_length[50]|valid_email'
                                         )
                                    ),
                                    
                  'addmenu' => array(
                                    array(
                                            'field' => 'nameAdd',
                                            'label' => 'name',
                                            'rules' => 'trim|required|max_length[40]|callback_duplicate_menu_name'
                                         ),
                                    array(
                                            'field' => 'urlAdd',
                                            'label' => 'URL',
                                            'rules' => 'trim|required|max_length[100]'
                                         ),
                                    array(
                                            'field' => 'publishAdd',
                                            'label' => 'publish',
                                            'rules' => 'required'
                                         )
                                    ),
                                    
                  
                  
                  
                  'adduser' => array(
                                    array(
                                            'field' => 'usernameAdd',
                                            'label' => 'username',
                                            'rules' => 'trim|required|max_length[30]|callback_duplicate_username'
                                         ),
                                    array(
                                            'field' => 'passwordAdd',
                                            'label' => 'first password',
                                            'rules' => 'trim|required|max_length[40]|min_length[8]'
                                         ),
                                    array(
                                            'field' => 'passwordTwoAdd',
                                            'label' => 'second password',
                                            'rules' => 'trim|required|max_length[40]|min_length[8]|matches[passwordAdd]'
                                         ),
                                    array(
                                            'field' => 'emailAdd',
                                            'label' => 'first email',
                                            'rules' => 'trim|required|max_length[50]|valid_email|callback_duplicate_email'
                                         ),
                                         
                                    array(
                                            'field' => 'emailTwoAdd',
                                            'label' => 'second email',
                                            'rules' => 'trim|required|max_length[50]|valid_email|matches[emailAdd]'
                                         ),
                                    array(
                                            'field' => 'adminRightsAdd',
                                            'label' => 'admin rights',
                                            'rules' => 'required'
                                         )
                                    
                                    ),
                                    
                  'login' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'username',
                                            'rules' => 'trim|required|max_length[30]'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'password',
                                            'rules' => 'trim|required|max_length[40]'
                                         )
                                    ),
                  
                   'contactus' => array(
                                    array(
                                            'field' => 'contactName',
                                            'label' => 'name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'contactNumber',
                                            'label' => 'phone',
                                            'rules' => 'trim|max_length[100]'
                                         ),
                                    array(
                                            'field' => 'contactEmail',
                                            'label' => 'email',
                                            'rules' => 'trim|required|max_length[100]|valid_email'
                                         ),
                                    array(
                                            'field' => 'contactDetails',
                                            'label' => 'message',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'zipcode',
                                            'label' => 'zipcode',
                                            'rules' => 'trim|exact_length[0]'
                                         )
                                    
                                    ),
                                    
    
               );