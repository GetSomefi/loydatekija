<?php
/**
 * The template for displaying the general contact information banner
 */
?>
<?php 
if( get_post_type( $get_the_id ) != "asiakaspuoli" ){
?>
<section class="beat-awesome-banner">
	<div class="beat-awesome-banner-inner">
		<h2 class="h1">YHTEYSHENKILÖT<br />SAMK</h2>
		<p>Aina voi tulla jotain kysyttävää, johon kaipaat vastausta. Alta löydät <b>Löydä tekijä</b>-palvelun yhteyshenkilöt, jotka vastaavat kinkkisimpiinkin rekryyn liittyviin kysymyksiin.</p>
		<div class="container text-center">
			<div class="row">
				<div class="col-sm-12 col-md-4">
					<h3>Nuutine</h3>
					<p>Nuutine vastaa siitä ja tosta. Nuutine vastaa siitä ja tosta. </p>
					<a class="beat-general-link" href="tel:0401111111">0401111111</a>
				</div>
				<div class="col-sm-12 col-md-4">
					<h3>Martti Kala</h3>
					<p>Martti Kala vastaa siitä ja tosta. Martti Kala vastaa siitä ja tosta. </p>
					<a class="beat-general-link" href="tel:0401111111">0401111112</a>
				</div>
				<div class="col-sm-12 col-md-4">
					<h3>The Marko</h3>
					<p>The Marko vastaa siitä ja tosta. The Marko vastaa siitä ja tosta. </p>
					<a class="beat-general-link" href="tel:0401111111">0401111113</a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>