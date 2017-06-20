<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message
{
	public function __construct(){}
	public function success_msg($msg="")
	{
		if($msg!="")
		{
			return "Hello";
		}
	}
}