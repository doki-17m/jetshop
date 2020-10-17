<?php

class Status {

	//status success insert
	public $SUCCESS_INSERT = ['success' => true,
							'message' => '<h5> Success!</h5> Your data has been inserted successfully!'];
	//status success update
	public $SUCCESS_UPDATE = ['success' => true,
							'message' => '<h5> Success!</h5> Your data has been updated successfully!'];
	//status success login
	public $SUCCESS_LOGIN = ['success' => '<h4><i class="icon fas fa-check"></i> Success!</h4> successfully!'];

	public $FAILED_LOGIN = ['error' => '<h4><i class="icon fas fa-check"></i> Error!</h4> Error!'];
	//active
	public $ACTIVE = 'Y';
	//nonactive
	public $NONACTIVE = 'Y';
	//zero value
	public $ZERO = 0;
	//customer
	public $CUSTOMER = 'Y';
	//supplier / vendor
	public $VENDOR = 'Y';
	//supplier / vendor
	public $SALESREP = 'Y';
}
