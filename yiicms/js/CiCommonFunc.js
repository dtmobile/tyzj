function validPluginDetailParam($pluginDetail)
{
  if($pluginDetail.odp_name=='')
  {
    return 'ODP名称不可以为空';
  }

   if($pluginDetail.name=='')
  {
    return '名称不可以为空';
  }

  if($pluginDetail.type!=0 && $pluginDetail.type!=1)
  {
    return '类型不可以为空';
  }

  if($pluginDetail.content=='')
  {
    return '内容不可以为空';
  }
  return '';
}
function IsNull(data){
  return (data == "" || data == undefined || data == null) ? true : false;
}
