<?php /* Smarty version 2.6.28, created on 2015-07-19 21:25:18
         compiled from table_row.tpl.html */ ?>
          <tr>
              <td><?php echo $this->_tpl_vars['ad']->getId(); ?>
</td>
              <td><?php echo $this->_tpl_vars['ad']->getTitle(); ?>
</td>
              <td><?php echo $this->_tpl_vars['ad']->getDesc(); ?>
</td>
              <td><?php echo $this->_tpl_vars['ad']->getPrice(); ?>
</td>
              <td>
              
              <a data-toggle="tooltip" title="Редактировать объявление" href=<?php echo $this->_tpl_vars['site_dir']; ?>
/<?php echo $this->_tpl_vars['current_php_script']; ?>
.php?edit=1&id=<?php echo $this->_tpl_vars['ad']->getId(); ?>
><span class='glyphicon glyphicon-edit'></span></a>
              
              <a data-toggle="tooltip" title="Удалить объявление" href=<?php echo $this->_tpl_vars['site_dir']; ?>
/<?php echo $this->_tpl_vars['current_php_script']; ?>
.php?del=1&id=<?php echo $this->_tpl_vars['ad']->getId(); ?>
><span class='glyphicon glyphicon-remove-circle'></span></a>
              
              
              </td>
          </tr>