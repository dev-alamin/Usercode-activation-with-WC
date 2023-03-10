<?php
get_header(); 

$certificate = woomc_get_print_certificate_item();

if ( $certificate ) :
    $ur_code =  $certificate->code;
    $ur_date = date('F j, Y', strtotime( $certificate->created_at ) );

?>
    <div id="certificate_area" class="certificate_area test" style="display:block !important;width: 600px; height: 424px; margin: 40px auto; position: relative; font-family: 'Roboto', sans-serif; font-size: 16px;">
        <img src="http://localhost/wp/wp-content/uploads/2022/10/certificate-scaled-1.jpg" width="600" height="424" class="cert-bg" alt="" />
        <table style="background-color: transparent; width: 400px; position: absolute; top: 230px; left: 0; right: 0; margin:0 auto">
            <tr>
                <td style="background-color: transparent !important; width: 100%; padding-left: 25px !important" colspan="2">
                    <h1 id="certificateName" style="color:#000; font-size: 20px; word-spacing: 5px; line-height: 1.5; margin: 12px 0 14px 0; height: 24px; overflow: hidden; font-weight: 600; text-align: center; text-transform: capitalize;">
                        <?php echo woomc_get_username_or_email(); ?>
                    </h1>
                </td>
            </tr>
            <tr>
                <td style="background-color: transparent !important; width: 50%; padding-left: 45px !important; text-align: center;">
                    <span style="height: 23px; display: inline-block;">
                        <img src="http://localhost/wp/wp-content/uploads/2022/10/benebear-certificate-template.png" style="max-width: 120px; max-height: 23px; object-fit: contain; margin-top: 4px" alt="">
                    </span>
                </td>
                <td style="background-color: transparent !important; width: 50%; padding-left: 10px; text-align: center;">
                    <span id="certificateDate" class="date_field" style="color:#000; width: 145px; display: inline-block; margin: 15px auto 0 auto; font-size: 14px; font-weight: 500; height: 22px;line-height: 1.3; overflow: hidden;">
                        <?php echo esc_html( $ur_date ) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="background-color: transparent !important; width: 100%; padding-left: 46px !important; padding-top: 8px !important; text-align: center;">
                    <span id="certificate_ur_code" style="height: 28px; display: inline-block; font-size: 14px; font-weight: 600; color:#000">
                        <?php echo esc_html( $ur_code ); ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <button class="btn_print"><?php _e('Print', 'woomc' ); ?></button>
<?php else : ?>

    <h4><?php _e( 'This page is only available when you have active bear on our site', 'woomc' ); ?></h4>
<?php endif; ?>

<?php get_footer();
