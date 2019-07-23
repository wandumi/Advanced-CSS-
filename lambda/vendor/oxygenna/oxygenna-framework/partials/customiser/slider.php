<?php
/**
 * Renders a slider for customiser
 *
 * @package Lambda
 * @subpackage Admin
 *
 * @copyright (c) 2015 Oxygenna.com
 * @license **LICENSE**
 * @version 1.38.0
 * @author Oxygenna.com
 */?>
<label>
    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <div></div>
    <input type="text" class="slider-option" value="<?php echo esc_attr( $this->value() ); ?>" min="<?php echo $this->choices['min']; ?>" max="<?php echo $this->choices['max']; ?>" step="<?php echo $this->choices['step']; ?>" <?php $this->link(); ?> />
</label>