<?php
namespace think;
class pageCore{
 /**
  * config ,public
  */
 var $page_name="p";//page标签，用来控制url页。比如说xxx.php?PB_page=2中的PB_page
 var $next_page='>';//下一页
 var $pre_page='<';//上一页
 var $first_page='First';//首页
 var $last_page='Last';//尾页
 var $pre_bar='<<';//上一分页条
 var $next_bar='>>';//下一分页条
 var $format_left='[';
 var $format_right=']';
 var $is_ajax=false;//是否支持AJAX分页模式 
 
 /**
  * private
  *
  */ 
 var $pagebarnum=10;//控制记录条的个数。
 var $totalpage=0;//总页数
 var $ajax_action_name='';//AJAX动作名
 var $nowindex=1;//当前页
 var $url="";//url地址头
 var $offset=0;//当前页起始记录数
 var $total;
 
 /**
  * constructor构造函数
  *
  * @param array $array['total'],$array['perpage'],$array['nowindex'],$array['url'],$array['ajax']...
  */
	public function pageCore($array) {
		if(is_array($array)){
			if(!array_key_exists('total',$array))$this->error(__FUNCTION__,'need a param of total');
			$total=intval($array['total']);
			$perpage=(array_key_exists('perpage',$array))?intval($array['perpage']):10;
			$nowindex=(array_key_exists('nowindex',$array))?intval($array['nowindex']):'';
			$url=(array_key_exists('url',$array))?$array['url']:'index';
		}else{
			$total=$array;
			$perpage=10;
			$nowindex='';
			$url='index';
		}
		if((!is_int($total))||($total<0))$this->error(__FUNCTION__,$total.' is not a positive integer!');
		if((!is_int($perpage))||($perpage<=0))$this->error(__FUNCTION__,$perpage.' is not a positive integer!');
		if(!empty($array['page_name']))$this->set('page_name',$array['page_name']);//设置pagename
		$this->_set_nowindex($nowindex);//设置当前页
		$this->_set_url($url);//设置链接地址
		$this->totalpage=ceil($total/$perpage);
		$this->offset=($this->nowindex-1)*$perpage;	// 当前页起始记录数
		if(!empty($array['ajax']))$this->open_ajax($array['ajax']);//打开AJAX模式
		$this->total = $total;
	}
	
	/**
	* 设定类中指定变量名的值，如果改变量不属于这个类，将throw一个exception
	*
	* @param string $var
	* @param string $value
	*/
	function set($var,$value) {
		if(in_array($var,get_object_vars($this))){
			$this->$var=$value;
		}else {
			$this->error(__FUNCTION__,$var." does not belong to PB_Page!");
		}
	
	}
	/**
	 * 打开倒AJAX模式
	 *
	 * @param string $action 默认ajax触发的动作。
	 */
	function open_ajax($action) {
		$this->is_ajax=true;
		$this->ajax_action_name=$action;
	}
	
	
	
	

 	////////////////
 	// 分页
 	////////////////
	/**
	 * 控制分页显示风格（你可以增加相应的风格）
	 *
	 * @param int $mode
	 * @return string
	 */
	function show($mode=1) {
		switch ($mode)
		{
			case '1':
				$this->first_page='首页';
				$this->last_page='末页';
				$this->pre_page='« 上一页';
				$this->next_page='下一页 »';
				return '<strong class="off">共'.$this->total.'条记录</strong>'.$this->first_page('','class="off"').$this->pre_page('','class="off"').$this->nowbar('','class="now"').$this->next_page('','class="off"').$this->last_page('','class="off"');
				break;
			case '2':
				$this->next_page='下一页';
				$this->pre_page='上一页';
				return $this->pre_page().$this->nowbar().$this->next_page()." - [共".$this->total."条数据]";
				break;
			case '3':
				$this->next_page='下一页';
				$this->pre_page='上一页';
				$this->first_page='首页';
				$this->last_page='尾页';
				return $this->first_page().$this->pre_page().'[第'.$this->nowindex.'页]'.$this->next_page().$this->last_page()." - [共".$this->total."条数据]";
				break;
			case '4':
				$this->first_page='首页';
				$this->last_page='尾页';
				$this->next_page='下一页';
				$this->pre_page='上一页';
				return $this->first_page().$this->pre_page().$this->next_page().$this->last_page()." - [共".$this->total."条数据]";
				break;
			case '5':
				$this->next_page='下一页';
				$this->pre_page='上一页';
				return $this->pre_page().$this->nowbar().$this->next_page()." - [".$this->total."条数据]";
				break;
			case '6':
				$this->next_page='下一页';
				$this->pre_page='上一页';
				return $this->pre_page(' class="prev" ', ' class="first" ').$this->nowbar().$this->next_page(' class="next" ', ' class="last" ');
				break;
            case '7':
                $this->first_page='首页';
                $this->last_page='尾页';
                $this->next_page='下一页';
                $this->pre_page='上一页';
                return $this->first_page().$this->pre_page(' class="prev"').$this->nowbar('',' class="cur" ').$this->next_page(' class="next" ').$this->last_page();
                break;
            case '8':
                $this->next_page='下一页';
                $this->pre_page='上一页';
                return $this->pre_page().'<span class="cur">'.$this->nowindex.'</span>'.$this->next_page();
                break;
            case '9':
	            return '<div>'.$this->pre_page(' class="prev" ') .$this->nowbar(' class="num" ',' class="current" ').$this->next_page(' class="next" ') .'  <span class="rows">共 '.$this->total.' 条记录</span> </div>';
            break;
		}
	}
	
	/**
	 * “首页”
	 */
	function first_page($style='',$disableStyle='') {
		if($this->nowindex==1){
			return '<strong '.$disableStyle.'>'.$this->first_page.'</strong>';
		}
		return $this->_get_link($this->_get_url(1),$this->first_page,$style);
	}
 
	/**
	 * “上一页”
	 */
	function pre_page($style='',$disableStyle='') {
		if($this->nowindex>1){
			return $this->_get_link($this->_get_url($this->nowindex-1),$this->pre_page,$style);
		}
		return '<strong '.$disableStyle.'>'.$this->pre_page.'</strong>';
	}
	
	/**
	 * “下一页”
	 */
	function next_page($style='',$disableStyle='') {
		if($this->nowindex<$this->totalpage){
			return $this->_get_link($this->_get_url($this->nowindex+1),$this->next_page,$style);
		}
		// p($this->nowindex);
		// p($this->totalpage);
		// die;
		return '<strong '.$disableStyle.'>'.$this->next_page.'</strong>';
	}
 
	/**
	 * “尾页”
	 */
	function last_page($style='',$disableStyle='') {
		if($this->nowindex==$this->totalpage){
			return '<strong '.$disableStyle.'>'.$this->last_page.'</strong>';
		}
		return $this->_get_link($this->_get_url($this->totalpage),$this->last_page,$style);
	}
	
	/**
	 * “迭代的页码链接”
	 */
	function nowbar($style='',$nowindex_style='now') {
		$plus=ceil($this->pagebarnum/2);
		if($this->pagebarnum-$plus+$this->nowindex>$this->totalpage)$plus=($this->pagebarnum-$this->totalpage+$this->nowindex);
		$begin=$this->nowindex-$plus+1;
		$begin=($begin>=1)?$begin:1;
		$return='';
		for($i=$begin;$i<$begin+$this->pagebarnum;$i++)
		{
			if($i<=$this->totalpage){
				if($i!=$this->nowindex){
					$return.=$this->_get_text($this->_get_link($this->_get_url($i),$i,$style));
				}else {
					$return.=$this->_get_text('<strong '.$nowindex_style.'>'.$i.'</strong>');
				}
			}else{
				break;
			}
			$return.="\n";
		}
		unset($begin);
		return $return;
	}
	
	/**
	 * 获取显示跳转按钮的代码
	 *
	 * @return string
	 */
	function select() {
		$return='<select name="PB_Page_Select">';
		for($i=1;$i<=$this->totalpage;$i++)
		{
			if($i==$this->nowindex){
				$return.='<option value="'.$i.'" selected>'.$i.'</option>';
			}else{
				$return.='<option value="'.$i.'">'.$i.'</option>';
			}
		}
		unset($i);
		$return.='</select>';
		return $return;
	}
	
	
	
	/*----------------private function (私有方法)-----------------------------------------------------------*/
	/**
	 * 获取mysql 语句中limit需要的值
	 *
	 * @return string
	 */
	function offset() {
		return $this->offset;
	}
 
	/**
	  * 获取链接地址
	*/
	function _get_link($url,$text,$style=''){
		if($this->is_ajax){
			//如果是使用AJAX模式
			return '<a '.$style.' href="javascript:'.$this->ajax_action_name.'(\''.$url.'\')">'.$text.'</a>';
		}else{
			return '<a '.$style.' href="/'.$url.'">'.$text.'</a>';
		}
	}
	
	/**
	 * 设置url头地址
	 * @param: String $url
	 * @return boolean
	 */
	function _set_url($url) {
		$this->url = $url;
	}
 
	/**
	 * 设置当前页面
	 *
	 */
	function _set_nowindex($nowindex) {
		if(empty($nowindex)){
			//系统获取
			if(isset($_GET[$this->page_name])){
				$this->nowindex=intval($_GET[$this->page_name]);
			}
		}else{
			//手动设置
			$this->nowindex=intval($nowindex);
		}
	}
  
	/**
	 * 为指定的页面返回地址值
	 *
	 * @param int $pageno
	 * @return string $url
	 */
	function _get_url($pageno=1) {
		return $this->url."page=".$pageno;
	}
 
	/**
	 * 获取分页显示文字，比如说默认情况下_get_text('<a href="">1</a>')将返回[<a href="">1</a>]
	 *
	 * @param String $str
	 * @return string $url
	 */ 
	function _get_text($str) {
		return $str;
	}
	
	/**
	* 出错处理方式
	*/
	function error($function,$errormsg) {
		die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
	}
}
?>
