<?php /* Smarty version 2.6.28, created on 2015-07-19 21:22:34
         compiled from oop.tpl */ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>OOP</title>

<!-- Latest compiled and minified CSS -->

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



</head>
<body style="width:500px; padding: 30px;">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'table.tpl.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!-- ФОРМА -->    
<form  class="form-horizontal" role="form" method="post">
    
    
<div class="form-group"> 
<label >
   
<input type="radio" <?php echo $this->_tpl_vars['checkedPrivate']; ?>
 value='1' name="private">Частное лицо

</label> 
    <label >
        
<input type="radio" <?php echo $this->_tpl_vars['checkedCompany']; ?>
 value='0' name="private">Компания</label> </div>


<!-- ИМЯ -->
    
<div class="form-group"> 
<label class="col-sm2 control-label" >
Ваше имя</label>
<input type="text" maxlength="40" class="form-input-text" 
       value="<?php echo $this->_tpl_vars['seller_name']; ?>
" name="seller_name" id="fld_seller_name">
</div>




<div class="form-group"> 
    <label for="fld_email" >Электронная почта</label>
    <input type="text" class="form-input-text"
           value="<?php echo $this->_tpl_vars['email']; ?>
" name="email" id="fld_email">
</div>
    
    
    
<div class="form-group"> 
    <div >
    <label class="form-label-checkbox" for="allow_mails">
<input type="checkbox" <?php echo $this->_tpl_vars['allow_mails']; ?>
 value="1" name="allow_mails" id="allow_mails" 
   class="form-input-checkbox">
<span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span>
    </label> </div>

</div>

   <!-- ТЕЛЕФОН -->
    
<div class="form-group"> 
    <label id="fld_phone_label" 
for="fld_phone" >Номер телефона</label> 
<input type="text" class="form-input-text" value="<?php echo $this->_tpl_vars['phone']; ?>
" name="phone" id="fld_phone">
</div>
    



<!-- ГОРОД -->

<div id="f_location_id" class="form-group"> 
<label for="region" class="form-label">Город</label> 
<select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
<option value="">-- Выберите город --</option>
<option class="opt-group" disabled="disabled">-- Города --</option>

<?php $_from = $this->_tpl_vars['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['city'] => $this->_tpl_vars['value']):
?>
    
<option 
    
       <?php if ($this->_tpl_vars['location_id'] == $this->_tpl_vars['value']): ?>
            <?php echo $this->_tpl_vars['selected']; ?>
 
    <?php endif; ?>
    
    data-coords=",," 
    value="<?php echo $this->_tpl_vars['value']; ?>
"
    ><?php echo $this->_tpl_vars['city']; ?>


</option>    
    
<?php endforeach; endif; unset($_from); ?>

</select></div>



<!-- МЕТРО -->

<div id="f_metro_id" class="form-group"> 
    <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" 
    class="form-input-select"> <option value="">-- Выберите станцию метро --</option>'

<?php $_from = $this->_tpl_vars['tube_stations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tube_station'] => $this->_tpl_vars['value2']):
?>
    
<option 
    
       <?php if ($this->_tpl_vars['tube_station_id'] == $this->_tpl_vars['value2']): ?>
            <?php echo $this->_tpl_vars['selected']; ?>
 
    <?php endif; ?>
    
    value="<?php echo $this->_tpl_vars['value2']; ?>
"
    ><?php echo $this->_tpl_vars['tube_station']; ?>


</option>    
<?php endforeach; endif; unset($_from); ?>

</select> </div>





<!-- КАТЕГОРИЯ -->

<div class="form-group"> 
<label for="fld_category_id" class="form-label">Категория</label> 
<select title="Выберите категорию объявления" name="category_id" 
id="fld_category_id" class="form-input-select">
<option value="">-- Выберите категорию --</option>

<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key4'] => $this->_tpl_vars['category']):
?>
    
<optgroup label="<?php echo $this->_tpl_vars['key4']; ?>
"> 
    
        <?php $_from = $this->_tpl_vars['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['value3']):
?>
    <option 
        
       <?php if ($this->_tpl_vars['category_id'] == $this->_tpl_vars['value3']): ?>
            <?php echo $this->_tpl_vars['selected']; ?>
 
    <?php endif; ?>
        
        value="<?php echo $this->_tpl_vars['value3']; ?>
"><?php echo $this->_tpl_vars['key3']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>

</optgroup>

<?php endforeach; endif; unset($_from); ?>

</select> </div>





<!-- НАЗВАНИЕ ОБЪЯВЛЕНИЯ -->

<div id="f_title" class="form-group"> 
<label for="fld_title" >Название объявления</label> 
<input type="text" maxlength="50" class="form-input-text-long" 
value="<?php echo $this->_tpl_vars['title']; ?>
" name="title" id="fld_title"> </div>






<!-- ОПИСАНИЕ ОБЪЯВЛЕНИЯ -->

<div class="form-group"> 
<label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label>
<textarea maxlength="3000" name="description" 
          id="fld_description" class="form-input-textarea"><?php echo $this->_tpl_vars['description']; ?>
</textarea> </div>

          
          
        
          
<!-- ЦЕНА ОБЪЯВЛЕНИЯ -->

<div id="price_rw" class="form-group"> 
<label id="price_lbl" for="fld_price" class="form-label">Цена</label> 
<input type="text" maxlength="9" class="form-input-text-short" value="<?php echo $this->_tpl_vars['price']; ?>
" 
name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span> 
<a class="link_plain grey right_price c-2 icon-link" id="js-price-link" 
   href="/info/pravilnye_ceny?plain"><span>Правильно указывайте цену</span></a> 
</div>



<!-- КНОПКИ  -->
    <div class="form-group" id="js_additem_form_submit">
        <div class="vas-submit-button pull-left"> <span class="vas-submit-border"></span> 
        <span class="vas-submit-triangle"></span> 

            <?php if ($this->_tpl_vars['post_edit']): ?>

<input type="submit" value="Сохранить объявление" id="form_submit" name="form" 
class="vas-submit-input">
<input type="submit" value="Назад" id="form_submit" name="form" class="vas-submit-input">
</div>

<?php else: ?>

    <input type="submit" value="Добавить" id="form_submit" name="main_form" 
        class="vas-submit-input">
        

        <?php endif; ?>
        
        </div>
    </div>
</form>


</body>
    </html>
    