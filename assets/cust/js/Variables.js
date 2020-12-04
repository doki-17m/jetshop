var ORI_URL = window.location.origin, //domain
	SITE_URL = window.location.href,
	LAST_URL = SITE_URL.substr(SITE_URL.lastIndexOf('/') + 1); //the last url
const SEGMENT_3 = ('/' + SITE_URL.split('/')[3]); //name host application index 3
var CUST_URL = ORI_URL + SEGMENT_3;

var url, ID, setSave, Toast, setAction;

var imgSrc = 0;

const classActive = $('.active'), //checkbox class active
	classSalesrep = $('.salesrep'), //checkbox class salesrep
	classObral = $('.obral'); //checkbox class obral

const classNumber = $('.number'),
	classBarcode = $('.barcode');

const active = 'Y', //value active
	nonactive = 'N'; //value nonactive

// const STORE = '/store';
const SHOWALL = '/showAll',
	CREATE = '/create',
	SHOW = '/show/',
	EDIT = '/edit/',
	DELETE = '/destroy/';

var modalDialog = $('.modal-dialog');
const modalTitle = $('.modal-title'),
	modalBody = $('.modal-body');

// Modals
const modalForm = $('#modal_form'), //Modal form
	modalList = $('#modal_list'); //Modal form

// Tables
var _tablePro, //Table master data product
	_tableCat, //Table master data category
	_tableJob, //Table master data job
	_tableGre, //Table master data greeting
	_tableUom, //Table master data uom
	_tableCus, //Table transaction customer
	_tableSup, //Table transaction supplier
	_tableProv, //Table transaction province
	_tableCity, //Table transaction city
	_tableCou, //Table transaction courier
	_tableAcc, //Table transaction account
	_tableUsr, //Table transaction user
	_tablePo, //Table transaction po
	_tableSo, //Table transaction so
	_tablePOS, //Table transaction pos
	_tableExp, //Table transaction expense
	_tableExpLine, //Table transaction expense line
	_tableRma, //Table transaction return
	_tableRmaLine; //Table transaction return line


//Forms
const soForm = $('#form_so'),
	proForm = $('#form_product'),
	catForm = $('#form_category'),
	greForm = $('#form_greeting'),
	uomForm = $('#form_uom'),
	cusForm = $('#form_customer'),
	supForm = $('#form_supplier'),
	provForm = $('#form_province'),
	cityForm = $('#form_city'),
	couForm = $('#form_courier'),
	accForm = $('#form_account'),
	usrForm = $('#form_user'),
	jobForm = $('#form_job'),
	lgnForm = $('#form_login'),
	chgForm = $('#form_chgpass'),
	expForm = $('#form_expense'),
	qtyForm = $('#form_quantity');

//Checkbox
const proActive = $('#pro_isactive'), //product
	catActive = $('#cat_isactive'), //category
	greActive = $('#gre_isactive'), //greeting
	uomActive = $('#uom_isactive'), //uom
	cusActive = $('#cus_isactive'), //customer
	supActive = $('#sup_isactive'), //customer
	provActive = $('#prov_isactive'), //province
	cityActive = $('#city_isactive'), //city
	couActive = $('#cou_isactive'), //courier
	accActive = $('#acc_isactive'), //account
	usrActive = $('#usr_isactive'), //user
	jobActive = $('#job_isactive'), //job
	proObral = $('#pro_isobral'); //product

//button
const btnNewSo = $('#new_so'), //button sales order
	btnNewPro = $('#new_product'), //button product
	btnNewCat = $('#new_category'), //button category
	btnNewGre = $('#new_greeting'), //button greeting
	btnNewUom = $('#new_uom'), //button uom
	btnNewCus = $('#new_customer'), //button customer
	btnNewSup = $('#new_supplier'), //button supplier
	btnNewDes = $('#new_destination'), //button destination
	btnNewProv = $('#new_province'), //button province
	btnNewCity = $('#new_city'), //button city
	btnNewCou = $('#new_courier'), //button courier
	btnNewAcc = $('#new_account'), //button account
	btnNewUsr = $('#new_user'), //button user
	btnNewJob = $('#new_job'), //button job
	btnNewExp = $('#new_expense'), //button expense
	btnNewExpLine = $('#new_expenseline'), //button expense line
	btnNewQty = $('#new_quantity'); //button new quantity

const btnSave = $('#save_form'),
	btnSList = $('#save_list'),
	btnNewDetails = $('#new_details'),
	btnLogin = $('#do_login');

const btnClose = $('#close_form'),
	// btnCList = $('#close_list'),
	btnCloseX = $('#close_form1');

// css class property
const isInvalid = ('is-invalid'),
	isValid = ('is-valid');

const CITY = '/city',
	PROVINCE = '/province',
	CATEGORY = '/category',
	UOM = '/uom',
	GREETING = '/greeting',
	USER = '/user',
	JOB = '/job',
	AUTH = '/auth',
	PRODUCT = '/product',
	SALES = '/sales',
	COURIER = '/courier',
	CUSTOMER = '/customer',
	EXPENSE = '/expense',
	ACCOUNT = '/account',
	INVENTORY = '/inventory';
