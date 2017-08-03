<?php 
if(!isset($_GET['flag_app'])) {
?>

<header id="header">
  <div class="container">
    <div class="top-navigation-logo">
        <a href="<?php echo home_url(); ?>" class="site-logo">
			<img src="https://ecs7.tokopedia.net/assets/images/tokopedia-logo.png" 
				 alt="Tokopedia Logo"
				 class="site__logo">
		</a>
    </div>
	<div class="bridge-widget">
		<a href="#" class="bw-pivot">
			<img src="https://ecs7.tokopedia.net/assets/images/ic_menu.png" 
					alt="" 
					width="30">
		</a>
		<div class="bw-container">
			<div class="bw-item">
				<a href="https://www.tokopedia.com/">
					<div class="bw-icon__wrapper">
						<div class="bw-icon bw-icon-toped"></div>
					</div>
					<p class="bw-icon__text">Jual Beli Online</p>
					<span class="clear-b"></span>
				</a>
			</div>
			<div class="bw-item">
				<a href="https://www.tokopedia.com/official-store">
					<div class="bw-icon__wrapper">
						<div class="bw-icon bw-icon-ofstore"></div>
					</div>
					<p class="bw-icon__text">Official Store</p>
					<span class="clear-b"></span>
				</a>
			</div>
			<div class="bw-item">
				<a href="https://www.tokopedia.com/pulsa">
					<div class="bw-icon__wrapper">
						<div class="bw-icon bw-icon-pulsa"></div>
					</div>
					<p class="bw-icon__text">Produk Digital</p>
					<span class="clear-b"></span>
				</a>
			</div>
			<div class="bw-item">
				<a href="https://tiket.tokopedia.com/">
					<div class="bw-icon__wrapper">
						<div class="bw-icon bw-icon-tiket"></div>
					</div>
					<p class="bw-icon__text">Tiket Kereta</p>
					<span class="clear-b"></span>
				</a>
			</div>
			<div class="bw-item">
				<a href="https://www.tokopedia.com/berbagi/">
					<div class="bw-icon__wrapper">
						<div class="bw-icon bw-icon-donasi"></div>
					</div>
					<p class="bw-icon__text">Donasi</p>
					<span class="clear-b"></span>
				</a>
			</div>
			<div class="bw-item">
				<a href="https://www.tokopedia.com/bantuan/">
					<div class="bw-icon__wrapper">
						<div class="bw-icon bw-icon-bantuan"></div>
					</div>
					<p class="bw-icon__text">Bantuan</p>
					<span class="clear-b"></span>
				</a>
			</div>
		</div> 
	</div>
	<div class="top-navigation-menu__ham"></div>
	<div class="site-overlay--ham"></div>
	<div class="top-navigation-menu">
		<div class="menu-header">
			MENU
			<div class="pull-right">
				<a href="#" class="menu-close">&times;</a>
			</div>
		</div>
		<?php //dynamic_sidebar( 'topnav-widget' ); ?>
	</div> 
  </div>
</header>

<?php
}
?>
<div class="site-overlay"></div>
