APP_PREFIX='standx';
BASE_URL='http://www.nan-x.com/cloud/standx/';
TMP_DIR=BASE_URL+'tmp/';
AJAX_ROOT=BASE_URL+'index.php/';
HELP_DIR=AJAX_ROOT+'dbdocu/gethelp/';
TREE_URL=AJAX_ROOT+'tree/';
CURD_URL=AJAX_ROOT+'curd/';
UPLOAD_URL='file/upload';
CURD_GETDATA_URL=CURD_URL+'listData';
LOGIN_URL=BASE_URL+'index.php/home/login';
Ext.BLANK_IMAGE_URL=BASE_URL+'jslib/ext/resources/images/default/s.gif';
pageSize=25;

if(Ext.MessageBox){Ext.MessageBox.minWidth=250;}
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
