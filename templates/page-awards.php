<?php
    /* Template Name: Awards Test */
?>
<section class="section_forms py4">
    <div class="container">
        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" 
              method="post" enctype="multipart/form-data" 
              class="tkpd-form forms-award clearfix py4 px4"
              id="seller-form">
            <?php wp_nonce_field( 'sellerstory_form', 'sellerstory_form_nonce' ); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <?php echo get_transient('error_msg'); ?>
                    <?php if(!empty(get_transient('error_msg'))) delete_transient('error_msg'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="tkpd-input select">
                        <div class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                        <label>Status</label>
                        <input type="text" id="seller_status" name="seller_status" value="<?php echo get_transient('user_status'); ?>" placeholder="Pilih Status" readonly="true">
                        <ul class="select">
                            <li class="option">
                                Seller
                            </li>
                            <li class="option">
                                Buyer
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="tkpd-input">
                        <label>Name</label>
                        <input type="text" name="seller_name" placeholder="Masukkan Nama" value="<?php echo get_transient('user_name'); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="tkpd-input">
                        <label>Email</label>
                        <input type="email" name="seller_email" placeholder="Masukkan Email" value="<?php echo get_transient('user_email'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="tkpd-input">
                        <label>URL Toko/User Profile</label>
                        <input type="text" name="seller_shop-url" placeholder="Masukkan URL Toko / User Profile" value="<?php echo get_transient('user_shopurl'); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="tkpd-input">
                        <label>Cerita Anda</label>
                        <textarea rows="10" name="seller_story" resize="vertical" placeholder="Tulis Cerita Anda di sini"><?php echo get_transient('user_body'); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="tkpd-input file">
                        <label for="seller_upload">
                            <span>Pilih File</span>
                            <div class="file-name"></div>
                        </label>
                        <span class="info">ekstensi file .doc, .docx, .pdf - maks 2MB</span>
                        <input type="file" id="seller_upload" name="seller_upload"></input>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <input type="hidden" name="action" value="sellerstory_submit" />
                    <input id="submission" type="submit" class="btn-tkpd btn--orange btn--medium btn-block" value="KIRIM"/>
                </div>
            </div>
            <?php $current_url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
            <input type="hidden" id="current_url" name="current_url" value=<?php echo $current_url; ?>></input>
        </form>
    </div>
</section>
<div class="placeholder"></div>
