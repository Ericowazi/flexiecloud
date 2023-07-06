<?php function head($head){ ?> <head> <?php echo $head; ?>  </head> <?php } ?>
<?php function ul($class, $id, $content){ ?> 
<ul class="<?php echo $class; ?>" id="<?php echo $id; ?>"> <?php echo $content; ?>  </ul> <?php } ?>

<?php function li($class, $id, $content){ ?> 
<li class="<?php echo $class; ?>" id="<?php echo $id; ?>"> <?php echo $content; ?>  </li> <?php } ?>

<?php function href($class, $id, $href, $content){ ?> 
<a class="<?php echo $class; ?>" id="<?php echo $id; ?>" href="<?php echo $href ?>"> <?php echo $content; ?>  </a> <?php } ?>
