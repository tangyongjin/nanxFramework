 

NANXplugin_window.prototype.btn12=function()
{
alert(1);
var whoami='admin';
var gridobj= new Act({
                 code: 'NANX_FS_2_TABLE',
                 pid_order:'desc',
                 os_path:'imgs',
                 file_trunk:5,
                 media_type:'img',
                 wintitle:i18n.message,
                 showwhere: 'autowin' 
                   });
                   
console.log(gridobj); 



}