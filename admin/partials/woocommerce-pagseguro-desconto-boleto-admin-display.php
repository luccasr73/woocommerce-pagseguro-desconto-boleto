<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       github.com/luccasr73
 * @since      1.0.0
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/admin/partials
 */
$discount_value = get_option( $this->plugin_name.'discount_value', 10 );
$active = get_option( $this->plugin_name.'discount_active', false );
$cumulative = get_option( $this->plugin_name.'discount_cumulative', false );
//var_dump($discount_value);
//var_dump($active);
//var_dump($cumulative);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<section class="section">
    <div class="container">
        <div class="box">
            <h1 class="title">WooCommerce PagSeguro desconto no boleto</h1>
            <?php 
            if( get_transient( $this->plugin_name.'error_set_discount_value' ) ) {
                $template = '';
                $template .='<div class="notification is-danger">';
                $template .= get_transient( $this->plugin_name.'error_set_discount_value' );
                $template .='</div>';
                echo($template);
                delete_transient( $this->plugin_name.'error_set_discount_value' );
            }
            ?>
            <form action="<?php echo( get_admin_url().'admin-post.php' ); ?>" method='post'>
                <input type='hidden' name='action' value='save_options'>
                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox" name="discount-active" id="discount-active" value="true" <?php 
                    if( $active ){
                        echo( 'checked' );
                    } 
                    ?>>
                        Ativar desconto
                    </label>
                </div>
                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox" name="discount-cumulative" id="discount-cumulative" value="true" <?php 
                    if( $cumulative ){
                        echo( 'checked' );
                    } 
                    ?>>
                        Cumulativo com cupons
                    </label>
                </div>
                <div class="field">
                    <label class="label">Porcentagem do desconto</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="10" name="discount-value" id="discount-value"
                            value="<?php echo( $discount_value ); ?>">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-link">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>