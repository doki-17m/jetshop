var ORI_URL = window.location.origin, //domain
	SITE_URL = window.location.href,
	LAST_URL = SITE_URL.substr(SITE_URL.lastIndexOf('/') + 1); //the last url
const SEGMENT_3 = ('/' + SITE_URL.split('/')[3]); //name host application index 3
var CUST_URL = ORI_URL + SEGMENT_3;

var url, ID, setSave, Toast, setAction;

var imgSrc = 0;

const classActive = $('.active'), //checkbox class active
	classSalesrep = $('.salesrep'); //checkbox class active

const classNumber = $('.number');

const active = 'Y', //value active
	nonactive = 'N'; //value nonactive

// const STORE = '/store';
const SHOWALL = '/showAll',
	CREATE = '/create',
	SHOW = '/show/',
	EDIT = '/edit/',
	DELETE = '/destroy/';

var modalDialog = $('.modal-dialog');
const modalTitle = $('.modal-title');

// Modals
const modalForm = $('#modal_form'), //Modal form
	modalUpload = $('#modal_upload'); //Modal form

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
	_tableSo; //Table transaction so

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
	lgnForm = $('#form_login');

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
	jobActive = $('#job_isactive'); //job

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
	btnNewAcc = $('#new_account'), //button courier
	btnNewUsr = $('#new_user'), //button user
	btnNewJob = $('#new_job'); //button job

const btnSave = $('#save_form'),
	btnUpload = $('#save_upload'),
	btnNewDetails = $('#new_details'),
	btnLogin = $('#do_login');

const btnClose = $('#close_form'),
	btnCloseX = $('.close');

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
	PRODUCT = '/product';
