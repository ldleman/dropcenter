<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


It's works !<br/><br/>

<h1> Title 1 </h1><br/>
<h2> Title 2 </h2><br/>
<h3> Title 3 </h3><br/>
<p> p </p><br/>
<span> span </span><br/>
<input> input </input><br/>
<textarea> textarea </textarea><br/>
<button> button </button><br/>
<select> <option>option</option> </select><br/>
<div> Div </div>	<br/>
<section> Section </section><br/>
<ul>
<li>Liste1</li>
<li>Liste2</li>
</ul>

<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>

