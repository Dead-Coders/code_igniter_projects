<?php

Class Auth
{
	 /*
	 	@param : none
	 	@return : bool
		@details : checks if the user_id session is set. used all over Lagos :)
	  */
		static function is_loggedin()
		{
			$CI = & get_instance();
			if ($CI->session->has_userdata('user_id') != '')
				return TRUE;
			else
				return FALSE;
		}


	/*
	 	@param : none
	 	@return : bool
		@details : Logs out the only possible account admin. I like that guy :)
	  */
		static function Logout()
		{
			$CI = & get_instance();
			unset($_SESSION['user_id']);
			unset($_SESSION['previous_url']);
			$CI->session->sess_destroy();
			redirect(site_url('authentication'));
		}

		/*
	 	@param : array()
	 	@return : bool
		@details : I jst login if the data matches the hardcoded guy. admin. 
	  */
		static function Login($data = array())
		{
			$CI = & get_instance();
			if(strtolower($data['email']) == 'admin@mail.com' && strtolower($data['password']) == 'admin123')
			{
				$userdata = [
				'user_id'=>1,
				'user_role'=>'Basic_Guy',
				'name'=>$data['email'],
				];
				$CI->session->set_userdata($userdata);
				return TRUE;
			}else{
				$CI->session->set_flashdata(ERROR, 'Invalid Username or Password');
				return FALSE;
			}
		}

		/*
			@param : string
		@details : Used to set a session so as to rember where the hell u are coming from if not logged in :)
		 */
		static function Bounce($uri_string = '')
		{
			$CI = & get_instance();
			$CI->session->set_userdata('previous_url', $uri_string);
			redirect(site_url());
		}

	}