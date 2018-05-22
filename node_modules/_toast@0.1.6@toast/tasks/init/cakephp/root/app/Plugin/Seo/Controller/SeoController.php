<?php

class SeoController extends AppController {

	public function robots() {
		$this->layout = null;
		switch(Configure::read('debug')) {
			case 0:
			case 1:
				$this->view = 'follow';
				break;
			case 2:
				$this->view = 'nofollow';
				break;
		}
	}
	
}