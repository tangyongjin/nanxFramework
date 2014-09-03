APP_PREFIX='standard';URL_ROOT='http://127.0.0.1/cloud/standard/';TMP_DIR=URL_ROOT+'tmp/';
AJAX_ROOT=URL_ROOT+'index.php/';
HELP_DIR=AJAX_ROOT+'Dbdocu/gethelp/';
TREE_URL=AJAX_ROOT+'tree/';
CURD_URL=AJAX_ROOT+'curd/';
UPLOAD_URL='file/upload';
CURD_GETDATA_URL=CURD_URL+'listData';
LOGIN_URL=URL_ROOT+'index.php/home/login';
Ext.BLANK_IMAGE_URL=URL_ROOT+'jslib/ext/resources/images/default/s.gif';
pageSize=25;

MEM_COPY_PASTE={'source':null,'target':null};
if(!window.console)
{
	varconsole={};
	console.log=function()
	{};
	console.clear=function()
	{};
}

Array.prototype.isArray=true;

